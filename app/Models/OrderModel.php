<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table         = 'orders';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'user_id', 'order_number', 'total_amount', 'payment_status',
        'order_status', 'snap_token', 'receiver_name', 'phone', 'email',
        'address', 'city', 'province', 'postal_code', 'notes'
    ];
    protected $useTimestamps  = true;
    protected $updatedField   = '';

    public function generateOrderNumber(): string
    {
        return 'INV-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }

    public function getByUser(int $userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getWithItems(int $orderId)
    {
        $order = $this->find($orderId);
        if (!$order) return null;

        $orderItemModel = new OrderItemModel();
        $order['items'] = $orderItemModel->getByOrder($orderId);

        return $order;
    }

    public function getTotalRevenue(): float
    {
        $result = $this->select('SUM(total_amount) as total')
                       ->where('payment_status', 'paid')
                       ->first();
        return (float) ($result['total'] ?? 0);
    }

    public function getTotalOrders(): int
    {
        return $this->countAll();
    }
}
