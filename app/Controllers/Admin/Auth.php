<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('admin_logged_in')) {
            return redirect()->to(base_url('admin/dashboard'));
        }
        return view('admin/auth/login', ['title' => 'Login Admin']);
    }

    public function doLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new UserModel();
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] !== 'aktif') {
                return redirect()->back()->with('error', 'Akun Anda tidak aktif.');
            }
            session()->set([
                'admin_logged_in' => true,
                'admin_id'        => $user['id'],
                'admin_nama'      => $user['nama'],
                'admin_email'     => $user['email'],
                'admin_role'      => $user['role'],
                'admin_foto'      => $user['foto'],
            ]);
            return redirect()->to(base_url('admin/dashboard'));
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('admin/login'));
    }
}
