<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table      = 'profile';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_perusahaan', 'logo', 'deskripsi', 'visi', 'misi', 'alamat', 'email', 'telepon', 'website'];

    public function getProfile()
    {
        return $this->first();
    }
}
