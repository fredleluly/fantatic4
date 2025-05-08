<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class User extends Controller
{
    protected $userModel;
    protected $helpers = ['url', 'form'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        
        $data['users'] = $this->userModel->where('deleted_at', null)->findAll();
        return view('user/user_view', $data);
    }

    public function create()
    {
        return view('user/create_user');
    }

    public function store()
{
    if ($this->request->getMethod() !== 'POST') {
        return redirect()->to(site_url('user'))->with('error', 'Invalid request method.');
    }

    // Aturan validasi
    $rules = [
        'Username' => 'required|is_unique[tb_dashboard.Username]', 
        'Level'    => 'required',
        'Status'   => 'required',
        'Nama'     => 'required',
        'Password' => 'required|min_length[6]',
        'Email'    => 'required|valid_email',
        'Phone'    => 'permit_empty|numeric|min_length[10]|max_length[15]',
        'Site'     => 'permit_empty|valid_url',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    try {
        // Pastikan username unik sebelum insert
        $existingUser = $this->userModel->where('Username', $this->request->getPost('Username'))->first();
        if ($existingUser) {
            return redirect()->back()->withInput()->with('error', 'Username sudah digunakan.');
        }

        $password = $this->request->getPost('Password'); // Simpan password sebelum di-hash
        $email = $this->request->getPost('Email');
        $username = $this->request->getPost('Username');

        $this->userModel->insert([
            'Username' => $username,
            'Level'    => $this->request->getPost('Level'),
            'Status'   => $this->request->getPost('Status'),
            'Nama'     => $this->request->getPost('Nama'),
            'Password' => password_hash($password, PASSWORD_DEFAULT), // Hash password
            'Src'      => $this->request->getPost('Src'),
            'Site'     => $this->request->getPost('Site'),
            'Phone'    => $this->request->getPost('Phone'),
            'Direct'   => $this->request->getPost('Direct'),
            'Email'    => $email
        ]);

        // Kirim email ke user baru
        $this->sendEmail($email, $username, $password);

        return redirect()->to(site_url('user'))->with('success', 'User berhasil ditambahkan dan email telah dikirim.');
    } catch (\Exception $e) {
        return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
    }
}

private function sendEmail($toEmail, $username, $password)
{
    $email = \Config\Services::email();

    $email->setFrom('itsupportpln@gmail.com', 'Admin');
    $email->setTo($toEmail);
    $email->setSubject('Akun Login Anda');
    
    $message = "
        <h3>Halo, $username!</h3>
        <p>Akun Anda telah dibuat oleh Admin. Berikut detail login Anda:</p>
        <p><b>Username:</b> $username</p>
        <p><b>Password:</b> $password</p>
        <p>Silakan login dan jika mau melakukan perubahan harap hubungi admin.</p>
    ";

    $email->setMessage($message);

    if ($email->send()) {
        return true;
    } else {
        return $email->printDebugger();
    }
}



public function edit($username)
{
    $data['user'] = $this->userModel->where('Username', $username)->first();
    
    if (!$data['user']) {
        return redirect()->to(base_url('user'))->with('error', 'User tidak ditemukan.');
    }
    
    return view('user/edit_user', $data);
}

public function update($username)
{
    $user = $this->userModel->where('Username', $username)->first();
    
    if (!$user) {
        return redirect()->to(base_url('user'))->with('error', 'User tidak ditemukan.');
    }

    $data = [
        'Level'  => $this->request->getPost('Level'),
        'Status' => $this->request->getPost('Status'),
        'Nama'   => $this->request->getPost('Nama'),
        'Src'    => $this->request->getPost('Src'),
        'Site'   => $this->request->getPost('Site'),
        'Phone'  => $this->request->getPost('Phone'),
        'Direct' => $this->request->getPost('Direct'),
        'Email'  => $this->request->getPost('Email')
    ];

    // Hash password jika ada input password baru
    if (!empty($this->request->getPost('Password'))) {
        $data['Password'] = password_hash($this->request->getPost('Password'), PASSWORD_DEFAULT);
    }

    // Update data berdasarkan Username
    $this->userModel->update($user['Username'], $data);

    // Redirect ke halaman user setelah update
    return redirect()->to(base_url('user'))->with('success', 'User berhasil diperbarui.');
}


    public function delete($username)
    {
        $user = $this->userModel->where('Username', $username)->first();
        
        if (!$user) {
            return redirect()->to('user')->with('error', 'User tidak ditemukan.');
        }
    
        // Update status menjadi "inactive" sebelum soft delete
        $this->userModel->update($username, ['Status' => 'inactive']);
    
        // Gunakan soft delete
        $this->userModel->delete($username);
    
        return redirect()->to('user')->with('success', 'User berhasil dihapus dan status diubah menjadi inactive.');
    }
    

    
}
