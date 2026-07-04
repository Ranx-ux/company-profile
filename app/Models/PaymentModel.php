<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table         = 'payments';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'order_id', 'transaction_id', 'payment_type',
        'gross_amount', 'transaction_status', 'raw_response'
    ];
    protected $useTimestamps  = true;
    protected $updatedField   = '';

    public function getByOrder(int $orderId)
    {
        return $this->where('order_id', $orderId)
                    ->orderBy('created_at', 'DESC')
                    ->first();
    }
}
