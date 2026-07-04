<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Services extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Kelola Layanan',
            'services' => $this->serviceModel->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('admin/services/index', $data);
    }

    public function create()
    {
        return view('admin/services/form', ['title' => 'Tambah Layanan', 'service' => null]);
    }

    public function store()
    {
        $rules = [
            'nama'      => 'required',
            'deskripsi' => 'required',
            'kategori'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarName = null;
        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            $gambarName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/services', $gambarName);
        }

        $this->serviceModel->insert([
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'icon'      => $this->request->getPost('icon'),
            'gambar'    => $gambarName,
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status') ?? 'aktif',
        ]);

        return redirect()->to(base_url('admin/services'))->with('success', 'Layanan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $service = $this->serviceModel->find($id);
        if (!$service) return redirect()->to(base_url('admin/services'))->with('error', 'Data tidak ditemukan.');

        return view('admin/services/form', ['title' => 'Edit Layanan', 'service' => $service]);
    }

    public function update($id)
    {
        $service = $this->serviceModel->find($id);
        if (!$service) return redirect()->to(base_url('admin/services'))->with('error', 'Data tidak ditemukan.');

        $rules = [
            'nama'      => 'required',
            'deskripsi' => 'required',
            'kategori'  => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarName = $service['gambar'];
        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Hapus gambar lama
            if ($gambarName && file_exists(ROOTPATH . 'public/uploads/services/' . $gambarName)) {
                unlink(ROOTPATH . 'public/uploads/services/' . $gambarName);
            }
            $gambarName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/services', $gambarName);
        }

        $this->serviceModel->update($id, [
            'nama'      => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'icon'      => $this->request->getPost('icon'),
            'gambar'    => $gambarName,
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('admin/services'))->with('success', 'Layanan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $service = $this->serviceModel->find($id);
        if (!$service) return redirect()->to(base_url('admin/services'))->with('error', 'Data tidak ditemukan.');

        if ($service['gambar'] && file_exists(ROOTPATH . 'public/uploads/services/' . $service['gambar'])) {
            unlink(ROOTPATH . 'public/uploads/services/' . $service['gambar']);
        }

        $this->serviceModel->delete($id);
        return redirect()->to(base_url('admin/services'))->with('success', 'Layanan berhasil dihapus.');
    }
}
