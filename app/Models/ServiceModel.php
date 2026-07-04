<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceModel extends Model
{
    protected $table      = 'services';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'deskripsi', 'icon', 'gambar', 'kategori', 'status'];
    protected $useTimestamps = true;
}
