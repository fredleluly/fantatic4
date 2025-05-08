<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'tb_dashboard'; // Nama tabel di database
    protected $primaryKey = 'Username'; // Primary Key (bukan auto-increment)
    protected $useAutoIncrement = false; // Matikan auto-increment karena Username bukan angka
    protected $allowedFields = ['Username', 'Level', 'Status', 'Nama', 'Password', 'Src', 'Site', 'Phone', 'Direct', 'Email'];
    protected $returnType    = 'array'; // Pastikan data dikembalikan dalam bentuk array

    // Mengaktifkan fitur Soft Delete
    protected $useSoftDeletes = true;
    protected $deletedField = 'deleted_at'; // Pastikan ada kolom ini di database
    public function cekLogin($Username, $Password)
{
    $user = $this->where('Username', $Username)
                 ->where('deleted_at', null) // Hanya ambil user yang belum dihapus
                 ->first();

    if ($user) {
        log_message('debug', 'User ditemukan: ' . json_encode($user)); // Debugging

        if (trim(strtolower($user['Status'])) === "inactive") {
            log_message('debug', 'Akun dalam status inactive.');
            return "inactive"; // Akun tidak aktif
        }
        
        if (password_verify($Password, $user['Password'])) {
            return $user;
        }
    }

    log_message('debug', 'User tidak ditemukan atau password salah.');
    return null;
}

    

}
