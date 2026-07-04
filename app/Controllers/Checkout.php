<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\PaymentModel;
use App\Models\ProductModel;
use App\Models\ProfileModel;
use App\Services\MidtransService;

class Checkout extends BaseController
{
    /**
     * Display checkout page.
     */
    public function index()
    {
        $cartItems = session()->get('cart') ?? [];

        if (empty($cartItems)) {
            return redirect()->to(base_url('cart'))->with('error', 'Keranjang Anda kosong.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += ($item['price'] * $item['qty']);
        }

        $data = [
            'title'   => 'Checkout',
            'profile' => (new ProfileModel())->getProfile(),
            'items'   => $cartItems,
            'total'   => $total,
        ];

        return view('frontend/checkout/index', $data);
    }

    /**
     * Process checkout - create order and get Snap token.
     */
    public function process()
    {
        $rules = [
            'receiver_name' => 'required|min_length[3]',
            'phone'         => 'required|min_length[8]',
            'email'         => 'required|valid_email',
            'address'       => 'required|min_length[10]',
            'city'          => 'required',
            'province'      => 'required',
            'postal_code'   => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $cartItems = session()->get('cart') ?? [];
        if (empty($cartItems)) {
            return redirect()->to(base_url('cart'))->with('error', 'Keranjang kosong.');
        }

        // Calculate total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += ($item['price'] * $item['qty']);
        }

        // Verify stock availability
        $productModel = new ProductModel();
        foreach ($cartItems as $productId => $item) {
            $product = $productModel->find($productId);
            if (!$product || $product['stock'] < $item['qty']) {
                return redirect()->back()->with('error', 'Stok "' . $item['name'] . '" tidak mencukupi.');
            }
        }

        $orderModel = new OrderModel();

        // Create order
        $orderId = $orderModel->insert([
            'user_id'        => session()->get('customer_id'),
            'order_number'   => $orderModel->generateOrderNumber(),
            'total_amount'   => $total,
            'payment_status' => 'pending',
            'order_status'   => 'pending',
            'receiver_name'  => $this->request->getPost('receiver_name'),
            'phone'          => $this->request->getPost('phone'),
            'email'          => $this->request->getPost('email'),
            'address'        => $this->request->getPost('address'),
            'city'           => $this->request->getPost('city'),
            'province'       => $this->request->getPost('province'),
            'postal_code'    => $this->request->getPost('postal_code'),
            'notes'          => $this->request->getPost('notes'),
        ]);

        $order = $orderModel->find($orderId);

        // Create order items
        $orderItemModel = new OrderItemModel();
        foreach ($cartItems as $item) {
            $orderItemModel->insert([
                'order_id'   => $orderId,
                'product_id' => $item['product_id'],
                'qty'        => $item['qty'],
                'price'      => $item['price'],
            ]);

            // Reduce stock
            $productModel->update($item['product_id'], [
                'stock' => $productModel->find($item['product_id'])['stock'] - $item['qty'],
            ]);
        }

        // Generate Midtrans Snap Token
        $midtrans = new MidtransService();

        $itemDetails = [];
        foreach ($cartItems as $item) {
            $itemDetails[] = [
                'id'    => $item['product_id'],
                'name'  => $item['name'],
                'price' => (int) $item['price'],
                'quantity' => $item['qty'],
            ];
        }

        $snapToken = $midtrans->getSnapToken([
            'order_id'     => $order['order_number'],
            'gross_amount' => $total,
            'first_name'   => $order['receiver_name'],
            'email'        => $order['email'],
            'phone'        => $order['phone'],
            'item_details' => $itemDetails,
        ]);

        // Update order with snap token
        $orderModel->update($orderId, ['snap_token' => $snapToken]);

        // Clear cart
        session()->remove('cart');

        if ($snapToken) {
            // Redirect to payment page with snap token
            return redirect()->to(base_url('checkout/success/' . $orderId));
        }

        return redirect()->to(base_url('checkout/pending/' . $orderId))->with('error', 'Gagal menghasilkan token pembayaran. Silakan coba lagi.');
    }

    /**
     * Payment success/pending page with Midtrans Snap.
     */
    public function success(int $orderId)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getWithItems($orderId);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $midtrans = new MidtransService();

        $data = [
            'title'      => 'Pembayaran',
            'profile'    => (new ProfileModel())->getProfile(),
            'order'      => $order,
            'snap_token' => $order['snap_token'],
            'client_key' => $midtrans->getClientKey(),
            'snap_js_url' => $midtrans->getSnapBaseUrl(),
        ];

        return view('frontend/checkout/success', $data);
    }

    /**
     * Payment pending page.
     */
    public function pending(int $orderId)
    {
        $orderModel = new OrderModel();
        $order = $orderModel->getWithItems($orderId);

        if (!$order) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'   => 'Pembayaran Pending',
            'profile' => (new ProfileModel())->getProfile(),
            'order'   => $order,
        ];

        return view('frontend/checkout/pending', $data);
    }
}
