<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProfileModel;

class Product extends BaseController
{
    public function index()
    {
        $productModel  = new ProductModel();
        $categoryModel = new CategoryModel();

        $categoryId = $this->request->getGet('category');
        $keyword    = $this->request->getGet('q');

        $builder = $productModel->withCategory();

        if ($categoryId) {
            $builder = $builder->where('products.category_id', $categoryId);
        }

        if ($keyword) {
            $builder = $builder->groupStart()
                        ->like('products.name', $keyword)
                        ->orLike('products.description', $keyword)
                        ->groupEnd();
        }

        $data = [
            'title'      => 'Produk',
            'profile'    => (new ProfileModel())->getProfile(),
            'products'   => $builder->orderBy('products.created_at', 'DESC')->paginate(12, 'products'),
            'pager'      => $productModel->pager,
            'categories' => $categoryModel->findAll(),
            'selectedCategory' => $categoryId,
            'keyword'    => $keyword,
        ];

        return view('frontend/products/index', $data);
    }

    public function detail(string $slug)
    {
        $productModel = new ProductModel();
        $product = $productModel->withCategory()->where('products.slug', $slug)->first();

        if (!$product) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $imageModel = new ProductImageModel();

        $data = [
            'title'   => $product['name'],
            'profile' => (new ProfileModel())->getProfile(),
            'product' => $product,
            'images'  => $imageModel->getByProduct($product['id']),
        ];

        return view('frontend/products/detail', $data);
    }
}
