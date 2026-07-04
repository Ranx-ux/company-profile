<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfileModel;

class Profile extends BaseController
{
    protected $profileModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Profil Perusahaan',
            'profile' => $this->profileModel->getProfile(),
        ];
        return view('admin/profile/index', $data);
    }

    public function update()
    {
        $profile = $this->profileModel->getProfile();

        $rules = [
            'nama_perusahaan' => 'required',
            'deskripsi'       => 'required',
            'alamat'          => 'required',
            'email'           => 'required|valid_email',
            'telepon'         => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $logoName = $profile['logo'] ?? null;

        // Upload logo jika ada
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $logoName = $logo->getRandomName();
            $logo->move(ROOTPATH . 'public/uploads/logo', $logoName);
        }

        $updateData = [
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'logo'            => $logoName,
            'deskripsi'       => $this->request->getPost('deskripsi'),
            'visi'            => $this->request->getPost('visi'),
            'misi'            => $this->request->getPost('misi'),
            'alamat'          => $this->request->getPost('alamat'),
            'email'           => $this->request->getPost('email'),
            'telepon'         => $this->request->getPost('telepon'),
            'website'         => $this->request->getPost('website'),
        ];

        if ($profile) {
            $this->profileModel->update($profile['id'], $updateData);
        } else {
            $this->profileModel->insert($updateData);
        }

        return redirect()->to(base_url('admin/profile'))->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
