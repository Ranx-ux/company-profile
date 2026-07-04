<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GalleryModel;

class Gallery extends BaseController
{
    protected $galleryModel;

    public function __construct()
    {
        $this->galleryModel = new GalleryModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Kelola Galeri',
            'gallery' => $this->galleryModel->orderBy('created_at', 'DESC')->findAll(),
        ];
        return view('admin/gallery/index', $data);
    }

    public function create()
    {
        return view('admin/gallery/form', ['title' => 'Tambah Foto Galeri', 'item' => null]);
    }

    public function store()
    {
        $rules = [
            'judul'    => 'required',
            'kategori' => 'required',
            'gambar'   => 'uploaded[gambar]|is_image[gambar]|max_size[gambar,2048]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambar = $this->request->getFile('gambar');
        $gambarName = $gambar->getRandomName();
        $gambar->move(ROOTPATH . 'public/uploads/gallery', $gambarName);

        $this->galleryModel->insert([
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $gambarName,
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status') ?? 'aktif',
        ]);

        return redirect()->to(base_url('admin/gallery'))->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $item = $this->galleryModel->find($id);
        if (!$item) return redirect()->to(base_url('admin/gallery'))->with('error', 'Data tidak ditemukan.');

        return view('admin/gallery/form', ['title' => 'Edit Foto Galeri', 'item' => $item]);
    }

    public function update($id)
    {
        $item = $this->galleryModel->find($id);
        if (!$item) return redirect()->to(base_url('admin/gallery'))->with('error', 'Data tidak ditemukan.');

        $rules = [
            'judul'    => 'required',
            'kategori' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $gambarName = $item['gambar'];
        $gambar = $this->request->getFile('gambar');
        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            if ($gambarName && file_exists(ROOTPATH . 'public/uploads/gallery/' . $gambarName)) {
                unlink(ROOTPATH . 'public/uploads/gallery/' . $gambarName);
            }
            $gambarName = $gambar->getRandomName();
            $gambar->move(ROOTPATH . 'public/uploads/gallery', $gambarName);
        }

        $this->galleryModel->update($id, [
            'judul'     => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'gambar'    => $gambarName,
            'kategori'  => $this->request->getPost('kategori'),
            'status'    => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('admin/gallery'))->with('success', 'Foto berhasil diperbarui.');
    }

    public function delete($id)
    {
        $item = $this->galleryModel->find($id);
        if (!$item) return redirect()->to(base_url('admin/gallery'))->with('error', 'Data tidak ditemukan.');

        if ($item['gambar'] && file_exists(ROOTPATH . 'public/uploads/gallery/' . $item['gambar'])) {
            unlink(ROOTPATH . 'public/uploads/gallery/' . $item['gambar']);
        }

        $this->galleryModel->delete($id);
        return redirect()->to(base_url('admin/gallery'))->with('success', 'Foto berhasil dihapus.');
    }
}
