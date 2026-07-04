<?php

namespace App\Controllers;

use App\Services\GoogleAuthService;
use App\Models\UserModel;

class Auth extends BaseController
{
    protected GoogleAuthService $googleAuth;
    protected UserModel $userModel;

    public function __construct()
    {
        $this->googleAuth = new GoogleAuthService();
        $this->userModel  = new UserModel();
    }

    /**
     * Show customer login page.
     */
    public function login()
    {
        // If already logged in, redirect to home
        if (session()->get('customer_logged_in')) {
            return redirect()->to(base_url());
        }

        $data = [
            'title'   => 'Login',
            'profile' => (new \App\Models\ProfileModel())->getProfile(),
        ];

        return view('frontend/auth/login', $data);
    }

    /**
     * Process email + password login.
     */
    public function doLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'] ?? '')) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah.');
        }

        if ($user['role'] !== 'customer') {
            return redirect()->back()->withInput()->with('error', 'Akun ini bukan akun customer.');
        }

        if ($user['status'] !== 'aktif') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif.');
        }

        // Set customer session
        session()->set([
            'customer_logged_in' => true,
            'customer_id'        => $user['id'],
            'customer_name'      => $user['nama'],
            'customer_email'     => $user['email'],
            'customer_avatar'    => $user['avatar'] ?? $user['foto'] ?? null,
            'customer_role'      => $user['role'],
        ]);

        // Redirect to intended page or home
        $intended = session()->get('intended_url');
        session()->remove('intended_url');

        return redirect()->to($intended ?? base_url())->with('success', 'Selamat datang, ' . $user['nama'] . '!');
    }

    /**
     * Show customer registration page.
     */
    public function register()
    {
        if (session()->get('customer_logged_in')) {
            return redirect()->to(base_url());
        }

        $data = [
            'title'   => 'Daftar Akun',
            'profile' => (new \App\Models\ProfileModel())->getProfile(),
        ];

        return view('frontend/auth/register', $data);
    }

    /**
     * Process customer registration.
     */
    public function doRegister()
    {
        $rules = [
            'nama'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'customer',
            'status'   => 'aktif',
        ]);

        return redirect()->to(base_url('auth/login'))->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * Redirect to Google OAuth login page (optional).
     */
    public function googleLogin()
    {
        if (session()->get('customer_logged_in')) {
            return redirect()->to(base_url());
        }

        $authUrl = $this->googleAuth->getAuthUrl();
        return redirect()->to($authUrl);
    }

    /**
     * Handle Google OAuth callback.
     */
    public function callback()
    {
        $code = $this->request->getGet('code');

        if (empty($code)) {
            return redirect()->to(base_url('auth/login'))->with('error', 'Login gagal. Silakan coba lagi.');
        }

        // Exchange code for token
        $tokenData = $this->googleAuth->authenticate($code);
        if (!$tokenData) {
            return redirect()->to(base_url('auth/login'))->with('error', 'Gagal autentikasi dengan Google.');
        }

        // Get user info from Google
        $googleUser = $this->googleAuth->getUserInfo($tokenData['access_token']);
        if (!$googleUser) {
            return redirect()->to(base_url('auth/login'))->with('error', 'Gagal mengambil data user dari Google.');
        }

        // Find or create user
        $user = $this->userModel->findByGoogleId($googleUser['id']);

        if (!$user) {
            $user = $this->userModel->findByEmail($googleUser['email']);

            if ($user) {
                $this->userModel->update($user['id'], [
                    'google_id' => $googleUser['id'],
                    'avatar'    => $googleUser['picture'] ?? null,
                ]);
            } else {
                $this->userModel->insert([
                    'nama'      => $googleUser['name'] ?? 'Google User',
                    'email'     => $googleUser['email'],
                    'google_id' => $googleUser['id'],
                    'avatar'    => $googleUser['picture'] ?? null,
                    'role'      => 'customer',
                    'status'    => 'aktif',
                ]);
                $user = $this->userModel->findByGoogleId($googleUser['id']);
            }
        }

        // Set customer session
        session()->set([
            'customer_logged_in' => true,
            'customer_id'        => $user['id'],
            'customer_name'      => $user['nama'],
            'customer_email'     => $user['email'],
            'customer_avatar'    => $user['avatar'],
            'customer_role'      => $user['role'],
        ]);

        $intended = session()->get('intended_url');
        session()->remove('intended_url');

        return redirect()->to($intended ?? base_url())->with('success', 'Selamat datang, ' . $user['nama'] . '!');
    }

    /**
     * Logout customer.
     */
    public function logout()
    {
        $customerData = [
            'customer_logged_in',
            'customer_id',
            'customer_name',
            'customer_email',
            'customer_avatar',
            'customer_role',
        ];

        session()->remove($customerData);
        return redirect()->to(base_url())->with('success', 'Anda telah logout.');
    }
}
