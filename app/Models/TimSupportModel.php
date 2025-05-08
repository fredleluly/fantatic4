<?php

namespace App\Models;
use CodeIgniter\Model;

class TimSupportModel extends Model
{
    protected $table = 'timsupport';
    protected $primaryKey = 'No'; // Sesuaikan dengan primary key tabel
    protected $allowedFields = ['Wilayah', 'Nama', 'Jabatan', 'Username', 'Status', 'Penempatan'];
}
