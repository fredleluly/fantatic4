<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $table = 'timsupport'; // Nama tabel
    protected $primaryKey = 'No'; // Primary Key tabel
    protected $useAutoIncrement = false; // Nonaktifkan auto-increment jika 'No' bukan auto-increment

    protected $allowedFields = [
        'No', 'Wilayah', 'Nama', 'Jabatan', 'Username', 'Status', 'Penempatan'
    ]; // Kolom yang bisa diisi (fillable)

    protected $returnType = 'array'; // Mengembalikan data dalam bentuk array

    // Jika perlu menggunakan timestamps
    public $timestamps = false;
    public function getRandomTeam()
    {
        return $this->orderBy('RAND()')->first(); // Ambil 1 data secara acak
    }
}
