<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller
{
    protected $userModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('auth/login');
    }

    public function login()
    {
        $request = $this->request;
        $username = $request->getPost('Username');
        $password = $request->getPost('Password');

        $user = $this->userModel->where('Username', $username)->first();

        if ($user) {
            // Cek apakah akun telah dinonaktifkan atau dihapus (soft delete)
            if (strtolower($user['Status']) === "inactive" || $user['deleted_at'] !== null) {
                return redirect()->back()->with('error', 'Akun Anda telah dinonaktifkan atau dihapus. Silakan hubungi admin.');
            }

            // Verifikasi password
            if (password_verify($password, $user['Password'])) {
                // Set session setelah login berhasil
                session()->set([
                    'Username'   => $user['Username'],
                    'Level'      => strtolower($user['Level']), // Simpan dalam lowercase agar konsisten
                    'isLoggedIn' => true
                ]);

                // Redirect ke dashboard utama (karena pengalihan sudah ditangani di `Dashboard.php`)
                return redirect()->to('/dashboard');
            }
        }

        return redirect()->back()->with('error', 'Username atau Password salah.');
    }

    public function logout()
    {
        session()->remove(['Username', 'Level', 'isLoggedIn']);
        return redirect()->to('/')->with('info', 'Anda telah logout.');
    }
}
