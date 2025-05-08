<?php

namespace App\Controllers;
use App\Models\TimSupportModel;
use CodeIgniter\Controller;

class Timsupport extends Controller
{
    public function index()
{
    $model = new TimSupportModel();
    $data['timsupport'] = $model->findAll(); // Ambil semua data

    // Cek level user yang login
    if (session()->get('Level') === 'user') {
        return view('timsupport/indexUser', $data);
    } else { // Default ke admin
        return view('timsupport/index', $data);
    }
}


    public function getData()
    {
        $model = new TimSupportModel();
        $wilayah = $this->request->getGet('wilayah');

        if ($wilayah) {
            $data = $model->where('Wilayah', $wilayah)->findAll();
        } else {
            $data = $model->findAll();
        }

        return $this->response->setJSON($data);
    }

    // Inside your TimSupport controller

// Get single record for editing
public function getSingle($id = null)
{
    if (!$id) {
        return $this->response->setJSON(['success' => false, 'message' => 'No ID provided']);
    }
    
    $model = new \App\Models\TimSupportModel();
    $data = $model->find($id);
    
    if (!$data) {
        return $this->response->setJSON(['success' => false, 'message' => 'Record not found']);
    }
    
    return $this->response->setJSON($data);
}

// Create new record
public function create()
{
    // Check for admin access
    if (session()->get('Level') !== 'admin') {
        return $this->response->setJSON(['success' => false, 'message' => 'Access denied']);
    }
    
    $model = new \App\Models\TimSupportModel();
    
    $data = [
        'Wilayah' => $this->request->getPost('wilayah'),
        'Nama' => $this->request->getPost('nama'),
        'Jabatan' => $this->request->getPost('jabatan'),
        'Username' => $this->request->getPost('username'),
        'Status' => $this->request->getPost('status'),
        'Penempatan' => $this->request->getPost('penempatan')
    ];
    
    if ($model->insert($data)) {
        return $this->response->setJSON(['success' => true, 'message' => 'Record added successfully']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to add record']);
    }
}

// Update existing record
public function update($id = null)
{
    // Check for admin access
    if (session()->get('Level') !== 'admin') {
        return $this->response->setJSON(['success' => false, 'message' => 'Access denied']);
    }
    
    if (!$id) {
        return $this->response->setJSON(['success' => false, 'message' => 'No ID provided']);
    }
    
    $model = new \App\Models\TimSupportModel();
    
    $data = [
        'Wilayah' => $this->request->getPost('wilayah'),
        'Nama' => $this->request->getPost('nama'),
        'Jabatan' => $this->request->getPost('jabatan'),
        'Username' => $this->request->getPost('username'),
        'Status' => $this->request->getPost('status'),
        'Penempatan' => $this->request->getPost('penempatan')
    ];
    
    if ($model->update($id, $data)) {
        return $this->response->setJSON(['success' => true, 'message' => 'Record updated successfully']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to update record']);
    }
}

// Delete record
public function delete($id = null)
{
    // Check for admin access
    if (session()->get('Level') !== 'admin') {
        return $this->response->setJSON(['success' => false, 'message' => 'Access denied']);
    }
    
    if (!$id) {
        return $this->response->setJSON(['success' => false, 'message' => 'No ID provided']);
    }
    
    $model = new \App\Models\TimSupportModel();
    
    if ($model->delete($id)) {
        return $this->response->setJSON(['success' => true, 'message' => 'Record deleted successfully']);
    } else {
        return $this->response->setJSON(['success' => false, 'message' => 'Failed to delete record']);
    }
}
}
