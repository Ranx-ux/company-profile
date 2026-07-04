<?php

namespace App\Controllers;

use App\Models\GalleryModel;
use App\Models\ProfileModel;

class Gallery extends BaseController
{
    public function index()
    {
        $galleryModel = new GalleryModel();
        $profileModel = new ProfileModel();
        $data = [
            'title'   => 'Galeri',
            'profile' => $profileModel->getProfile(),
            'gallery' => $galleryModel->where('status', 'aktif')->findAll(),
        ];
        return view('frontend/gallery', $data);
    }
}
