<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;

class Products extends BaseController
{
    protected ProductModel $productModel;
    protected CategoryModel $categoryModel;
    protected ProductImageModel $imageModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->imageModel    = new ProductImageModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Produk',
            'products' => $this->productModel->withCategory()->orderBy('products.created_at', 'DESC')->findAll(),
        ];
        return view('admin/products/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Tambah Produk',
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('admin/products/form', $data);
    }

    public function store()
    {
        $rules = [
            'name'        => 'required|min_length[3]',
            'category_id' => 'required|numeric',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'required',
            'thumbnail'   => [
                'rules'  => 'max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => ['max_size' => 'Ukuran thumbnail maksimal 2MB'],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $name = $this->request->getPost('name');
        $thumbnail = null;

        // Upload thumbnail
        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $thumbnail = $file->getRandomName();
            $file->move(FCPATH . 'uploads/products/', $thumbnail);
        }

        $productId = $this->productModel->insert([
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $name,
            'slug'        => url_title($name, '-', true),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
            'thumbnail'   => $thumbnail,
        ]);

        // Upload additional images
        $images = $this->request->getFileMultiple('images');
        if ($images) {
            foreach ($images as $img) {
                if ($img && $img->isValid() && !$img->hasMoved()) {
                    $imageName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/products/', $imageName);
                    $this->imageModel->insert([
                        'product_id' => $productId,
                        'image'      => $imageName,
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/products'))->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to(base_url('admin/products'))->with('error', 'Produk tidak ditemukan.');
        }

        $data = [
            'title'      => 'Edit Produk',
            'product'    => $product,
            'categories' => $this->categoryModel->findAll(),
            'images'     => $this->imageModel->getByProduct($id),
        ];
        return view('admin/products/form', $data);
    }

    public function update(int $id)
    {
        $rules = [
            'name'        => 'required|min_length[3]',
            'category_id' => 'required|numeric',
            'price'       => 'required|numeric',
            'stock'       => 'required|numeric',
            'description' => 'required',
            'thumbnail'   => [
                'rules'  => 'max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => ['max_size' => 'Ukuran thumbnail maksimal 2MB'],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $product = $this->productModel->find($id);
        $name = $this->request->getPost('name');

        $updateData = [
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $name,
            'slug'        => url_title($name, '-', true),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'stock'       => $this->request->getPost('stock'),
        ];

        // Upload new thumbnail if provided
        $file = $this->request->getFile('thumbnail');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Delete old thumbnail
            if ($product['thumbnail'] && file_exists(FCPATH . 'uploads/products/' . $product['thumbnail'])) {
                unlink(FCPATH . 'uploads/products/' . $product['thumbnail']);
            }
            $thumbnail = $file->getRandomName();
            $file->move(FCPATH . 'uploads/products/', $thumbnail);
            $updateData['thumbnail'] = $thumbnail;
        }

        $this->productModel->update($id, $updateData);

        // Upload additional images
        $images = $this->request->getFileMultiple('images');
        if ($images) {
            foreach ($images as $img) {
                if ($img && $img->isValid() && !$img->hasMoved()) {
                    $imageName = $img->getRandomName();
                    $img->move(FCPATH . 'uploads/products/', $imageName);
                    $this->imageModel->insert([
                        'product_id' => $id,
                        'image'      => $imageName,
                    ]);
                }
            }
        }

        return redirect()->to(base_url('admin/products'))->with('success', 'Produk berhasil diupdate.');
    }

    public function delete(int $id)
    {
        $product = $this->productModel->find($id);
        if ($product && $product['thumbnail'] && file_exists(FCPATH . 'uploads/products/' . $product['thumbnail'])) {
            unlink(FCPATH . 'uploads/products/' . $product['thumbnail']);
        }

        // Delete product images
        $images = $this->imageModel->getByProduct($id);
        foreach ($images as $img) {
            if (file_exists(FCPATH . 'uploads/products/' . $img['image'])) {
                unlink(FCPATH . 'uploads/products/' . $img['image']);
            }
        }

        $this->productModel->delete($id);
        return redirect()->to(base_url('admin/products'))->with('success', 'Produk berhasil dihapus.');
    }

    public function deleteImage(int $id)
    {
        $image = $this->imageModel->find($id);
        if ($image) {
            if (file_exists(FCPATH . 'uploads/products/' . $image['image'])) {
                unlink(FCPATH . 'uploads/products/' . $image['image']);
            }
            $this->imageModel->delete($id);
            return $this->response->setJSON(['success' => true]);
        }
        return $this->response->setJSON(['success' => false]);
    }
}
