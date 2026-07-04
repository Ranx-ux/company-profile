<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'email', 'password', 'google_id', 'avatar', 'role', 'foto', 'status'];
    protected $useTimestamps = true;
    protected $hidden = ['password'];

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    public function findByGoogleId(string $googleId)
    {
        return $this->where('google_id', $googleId)->first();
    }

    public function getCustomers()
    {
        return $this->where('role', 'customer')
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
