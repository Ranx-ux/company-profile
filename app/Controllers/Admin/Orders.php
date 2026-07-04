<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\OrderModel;
use App\Models\PaymentModel;

class Orders extends BaseController
{
    protected OrderModel $orderModel;
    protected PaymentModel $paymentModel;

    public function __construct()
    {
        $this->orderModel   = new OrderModel();
        $this->paymentModel = new PaymentModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Pesanan',
            'orders' => $this->orderModel->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('admin/orders/index', $data);
    }

    public function detail(int $id)
    {
        $order = $this->orderModel->getWithItems($id);
        if (!$order) {
            return redirect()->to(base_url('admin/orders'))->with('error', 'Pesanan tidak ditemukan.');
        }

        $data = [
            'title'   => 'Detail Pesanan',
            'order'   => $order,
            'payment' => $this->paymentModel->getByOrder($id),
        ];
        return view('admin/orders/detail', $data);
    }

    public function updateStatus(int $id)
    {
        $orderStatus   = $this->request->getPost('order_status');
        $paymentStatus = $this->request->getPost('payment_status');

        $updateData = [];
        if ($orderStatus) $updateData['order_status'] = $orderStatus;
        if ($paymentStatus) $updateData['payment_status'] = $paymentStatus;

        $this->orderModel->update($id, $updateData);

        return redirect()->to(base_url('admin/orders/detail/' . $id))->with('success', 'Status pesanan berhasil diupdate.');
    }
}
