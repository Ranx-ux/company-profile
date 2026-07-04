<?php

namespace App\Controllers;

use App\Models\ProfileModel;
use App\Models\ServiceModel;
use App\Models\GalleryModel;
use App\Models\ProductModel;

class Home extends BaseController
{
    public function index()
    {
        $profileModel = new ProfileModel();
        $serviceModel = new ServiceModel();
        $galleryModel = new GalleryModel();
        $productModel = new ProductModel();

        $data = [
            'title'    => 'Beranda',
            'profile'  => $profileModel->getProfile(),
            'services' => $serviceModel->where('status', 'aktif')->findAll(6),
            'gallery'  => $galleryModel->where('status', 'aktif')->findAll(6),
            'products' => $productModel->getLatest(8),
        ];

        return view('frontend/home', $data);
    }
}
