<?php

namespace App\Controllers;

use App\Models\ServiceModel;
use App\Models\ProfileModel;

class Services extends BaseController
{
    public function index()
    {
        $serviceModel = new ServiceModel();
        $profileModel = new ProfileModel();
        $data = [
            'title'    => 'Produk & Layanan',
            'profile'  => $profileModel->getProfile(),
            'services' => $serviceModel->where('status', 'aktif')->findAll(),
        ];
        return view('frontend/services', $data);
    }
}
