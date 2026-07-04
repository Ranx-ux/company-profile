<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table         = 'products';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['category_id', 'name', 'slug', 'description', 'price', 'stock', 'thumbnail'];
    protected $useTimestamps  = true;

    public function findBySlug(string $slug)
    {
        return $this->where('slug', $slug)->first();
    }

    public function withCategory()
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id', 'left');
    }

    public function getLatest(int $limit = 8)
    {
        return $this->withCategory()
                    ->orderBy('products.created_at', 'DESC')
                    ->findAll($limit);
    }

    public function search(string $keyword)
    {
        return $this->withCategory()
                    ->groupStart()
                        ->like('products.name', $keyword)
                        ->orLike('products.description', $keyword)
                    ->groupEnd();
    }

    public function getByCategory(int $categoryId)
    {
        return $this->withCategory()
                    ->where('products.category_id', $categoryId);
    }
}
