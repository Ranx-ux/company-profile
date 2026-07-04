<?php

namespace App\Models;

use CodeIgniter\Model;

class CartItemModel extends Model
{
    protected $table         = 'cart_items';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['cart_id', 'product_id', 'qty', 'price'];
    protected $useTimestamps  = false;

    public function getByCart(int $cartId)
    {
        return $this->select('cart_items.*, products.name as product_name, products.thumbnail, products.stock, products.slug')
                    ->join('products', 'products.id = cart_items.product_id', 'left')
                    ->where('cart_items.cart_id', $cartId)
                    ->findAll();
    }

    public function findByCartAndProduct(int $cartId, int $productId)
    {
        return $this->where('cart_id', $cartId)
                    ->where('product_id', $productId)
                    ->first();
    }

    public function getCartTotal(int $cartId): float
    {
        $result = $this->select('SUM(qty * price) as total')
                       ->where('cart_id', $cartId)
                       ->first();
        return (float) ($result['total'] ?? 0);
    }

    public function getCartCount(int $cartId): int
    {
        $result = $this->select('SUM(qty) as count')
                       ->where('cart_id', $cartId)
                       ->first();
        return (int) ($result['count'] ?? 0);
    }
}
