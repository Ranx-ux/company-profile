<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Kategori',
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('admin/categories/index', $data);
    }

    public function create()
    {
        return view('admin/categories/form', ['title' => 'Tambah Kategori']);
    }

    public function store()
    {
        $rules = ['name' => 'required|min_length[3]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $this->categoryModel->insert([
            'name' => $name,
            'slug' => url_title($name, '-', true),
        ]);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to(base_url('admin/categories'))->with('error', 'Kategori tidak ditemukan.');
        }
        return view('admin/categories/form', ['title' => 'Edit Kategori', 'category' => $category]);
    }

    public function update(int $id)
    {
        $rules = ['name' => 'required|min_length[3]'];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $this->categoryModel->update($id, [
            'name' => $name,
            'slug' => url_title($name, '-', true),
        ]);

        return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $this->categoryModel->delete($id);
        return redirect()->to(base_url('admin/categories'))->with('success', 'Kategori berhasil dihapus.');
    }
}
