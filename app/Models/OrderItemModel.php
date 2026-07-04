<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table         = 'order_items';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['order_id', 'product_id', 'qty', 'price'];
    protected $useTimestamps  = false;

    public function getByOrder(int $orderId)
    {
        return $this->select('order_items.*, products.name as product_name, products.thumbnail, products.slug')
                    ->join('products', 'products.id = order_items.product_id', 'left')
                    ->where('order_items.order_id', $orderId)
                    ->findAll();
    }

    public function createFromCartItems(int $orderId, array $cartItems)
    {
        foreach ($cartItems as $item) {
            $this->insert([
                'order_id'   => $orderId,
                'product_id' => $item['product_id'],
                'qty'        => $item['qty'],
                'price'      => $item['price'],
            ]);
        }
    }
}
