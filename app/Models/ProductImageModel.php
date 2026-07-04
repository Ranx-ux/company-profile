<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table         = 'product_images';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['product_id', 'image'];
    protected $useTimestamps  = false;

    public function getByProduct(int $productId)
    {
        return $this->where('product_id', $productId)->findAll();
    }

    public function deleteByProduct(int $productId)
    {
        return $this->where('product_id', $productId)->delete();
    }
}
