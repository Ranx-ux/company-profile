<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\OrderModel;

class Customers extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Customer',
            'customers' => $this->userModel->getCustomers(),
        ];
        return view('admin/customers/index', $data);
    }

    public function detail(int $id)
    {
        $customer = $this->userModel->find($id);
        if (!$customer || $customer['role'] !== 'customer') {
            return redirect()->to(base_url('admin/customers'))->with('error', 'Customer tidak ditemukan.');
        }

        $orderModel = new OrderModel();

        $data = [
            'title'    => 'Detail Customer',
            'customer' => $customer,
            'orders'   => $orderModel->getByUser($id),
        ];
        return view('admin/customers/detail', $data);
    }
}
