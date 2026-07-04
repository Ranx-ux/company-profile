<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;
use App\Models\GalleryModel;
use App\Models\UserModel;
use App\Models\ProfileModel;
use App\Models\ProductModel;
use App\Models\OrderModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $orderModel = new OrderModel();
        $userModel  = new UserModel();

        $data = [
            'title'            => 'Dashboard',
            'total_services'   => (new ServiceModel())->countAll(),
            'total_gallery'    => (new GalleryModel())->countAll(),
            'total_products'   => (new ProductModel())->countAll(),
            'total_orders'     => $orderModel->getTotalOrders(),
            'total_customers'  => $userModel->where('role', 'customer')->countAllResults(),
            'total_revenue'    => $orderModel->getTotalRevenue(),
            'total_users'      => $userModel->where('role !=', 'customer')->countAllResults(),
            'profile'          => (new ProfileModel())->getProfile(),
        ];
        return view('admin/dashboard', $data);
    }
}
