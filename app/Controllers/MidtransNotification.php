<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\PaymentModel;
use App\Services\MidtransService;

class MidtransNotification extends BaseController
{
    /**
     * Handle Midtrans webhook notification.
     * This endpoint is called by Midtrans server to notify payment status changes.
     */
    public function notify()
    {
        $midtrans = new MidtransService();

        // Get notification JSON
        $json = $this->request->getJSON(true);

        if (!$json) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid notification']);
        }

        // Verify notification by checking transaction status from Midtrans API
        $transactionStatus = $midtrans->handleNotification($json);

        if (!$transactionStatus) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid transaction']);
        }

        $orderNumber       = $transactionStatus['order_id'] ?? '';
        $midtransStatus    = $transactionStatus['transaction_status'] ?? '';
        $paymentType       = $transactionStatus['payment_type'] ?? '';
        $transactionId     = $transactionStatus['transaction_id'] ?? '';
        $grossAmount       = $transactionStatus['gross_amount'] ?? 0;

        // Map to our payment status
        $paymentStatus = $midtrans->mapPaymentStatus($midtransStatus);

        // Find order by order_number
        $orderModel = new OrderModel();
        $order = $orderModel->where('order_number', $orderNumber)->first();

        if (!$order) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Order not found']);
        }

        // Update order payment status
        $orderModel->update($order['id'], [
            'payment_status' => $paymentStatus,
        ]);

        // If paid, update order status to processing
        if ($paymentStatus === 'paid') {
            $orderModel->update($order['id'], [
                'order_status' => 'processing',
            ]);
        }

        // If cancelled/failed/expired, restore stock
        if (in_array($paymentStatus, ['cancelled', 'failed', 'expired'])) {
            $orderModel->update($order['id'], [
                'order_status' => 'cancelled',
            ]);

            // Restore product stock
            $this->restoreStock($order['id']);
        }

        // Save payment record
        $paymentModel = new PaymentModel();
        $paymentModel->insert([
            'order_id'           => $order['id'],
            'transaction_id'     => $transactionId,
            'payment_type'       => $paymentType,
            'gross_amount'       => $grossAmount,
            'transaction_status' => $midtransStatus,
            'raw_response'       => json_encode($transactionStatus),
        ]);

        return $this->response->setJSON(['status' => 'ok']);
    }

    /**
     * Restore product stock when order is cancelled/failed/expired.
     */
    protected function restoreStock(int $orderId)
    {
        $db = \Config\Database::connect();
        $items = $db->table('order_items')
                    ->where('order_id', $orderId)
                    ->get()
                    ->getResultArray();

        $productModel = new \App\Models\ProductModel();

        foreach ($items as $item) {
            $product = $productModel->find($item['product_id']);
            if ($product) {
                $productModel->update($item['product_id'], [
                    'stock' => $product['stock'] + $item['qty'],
                ]);
            }
        }
    }
}
