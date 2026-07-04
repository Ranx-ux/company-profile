<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola User Admin',
            'users' => $this->userModel->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/form', ['title' => 'Tambah User', 'user' => null]);
    }

    public function store()
    {
        $rules = [
            'nama'     => 'required',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoName = null;
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/users', $fotoName);
        }

        $this->userModel->insert([
            'nama'     => $this->request->getPost('nama'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => $this->request->getPost('role'),
            'foto'     => $fotoName,
            'status'   => $this->request->getPost('status') ?? 'aktif',
        ]);

        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');

        return view('admin/users/form', ['title' => 'Edit User', 'user' => $user]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');

        $rules = [
            'nama'  => 'required',
            'email' => "required|valid_email|is_unique[users.email,id,{$id}]",
            'role'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fotoName = $user['foto'];
        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if ($fotoName && file_exists(ROOTPATH . 'public/uploads/users/' . $fotoName)) {
                unlink(ROOTPATH . 'public/uploads/users/' . $fotoName);
            }
            $fotoName = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads/users', $fotoName);
        }

        $updateData = [
            'nama'   => $this->request->getPost('nama'),
            'email'  => $this->request->getPost('email'),
            'role'   => $this->request->getPost('role'),
            'foto'   => $fotoName,
            'status' => $this->request->getPost('status'),
        ];

        // Update password hanya jika diisi
        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $updateData);
        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil diperbarui.');
    }

    public function delete($id)
    {
        // Cegah hapus diri sendiri
        if ($id == session()->get('admin_id')) {
            return redirect()->to(base_url('admin/users'))->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user = $this->userModel->find($id);
        if (!$user) return redirect()->to(base_url('admin/users'))->with('error', 'User tidak ditemukan.');

        if ($user['foto'] && file_exists(ROOTPATH . 'public/uploads/users/' . $user['foto'])) {
            unlink(ROOTPATH . 'public/uploads/users/' . $user['foto']);
        }

        $this->userModel->delete($id);
        return redirect()->to(base_url('admin/users'))->with('success', 'User berhasil dihapus.');
    }
}
