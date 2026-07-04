<?php

namespace App\Controllers;

use App\Models\ProfileModel;

class Contact extends BaseController
{
    public function index()
    {
        $profileModel = new ProfileModel();
        $data = [
            'title'   => 'Kontak',
            'profile' => $profileModel->getProfile(),
        ];
        return view('frontend/contact', $data);
    }

    public function send()
    {
        // Validasi input
        $rules = [
            'nama'    => 'required|min_length[3]',
            'email'   => 'required|valid_email',
            'subjek'  => 'required|min_length[5]',
            'pesan'   => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan ke session sebagai notifikasi (bisa dikembangkan ke email/DB)
        session()->setFlashdata('success', 'Pesan Anda berhasil dikirim. Kami akan segera menghubungi Anda.');
        return redirect()->to(base_url('contact'));
    }
}
