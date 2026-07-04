<?php

namespace App\Models;

use CodeIgniter\Model;

class CartModel extends Model
{
    protected $table         = 'carts';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['user_id'];
    protected $useTimestamps  = false;

    public function getByUser(int $userId)
    {
        return $this->where('user_id', $userId)->first();
    }

    public function getOrCreate(int $userId)
    {
        $cart = $this->getByUser($userId);
        if (!$cart) {
            $this->insert(['user_id' => $userId]);
            $cart = $this->getByUser($userId);
        }
        return $cart;
    }
}
