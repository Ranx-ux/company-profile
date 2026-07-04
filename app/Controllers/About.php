<?php

namespace App\Controllers;

use App\Models\ProfileModel;

class About extends BaseController
{
    public function index()
    {
        $profileModel = new ProfileModel();
        $data = [
            'title'   => 'Tentang Kami',
            'profile' => $profileModel->getProfile(),
        ];
        return view('frontend/about', $data);
    }
}
