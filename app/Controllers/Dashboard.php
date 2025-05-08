<?php

namespace App\Controllers;

use App\Models\DashboardModel;
use CodeIgniter\RESTful\ResourceController;

class Dashboard extends ResourceController
{
    protected $dashboardModel;

    public function __construct()
    {
        $this->dashboardModel = new DashboardModel();
    }

    public function index()
    {
        // Pastikan user sudah login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil level user dari session
        $level = strtolower(session()->get('Level'));

        // Tentukan tampilan berdasarkan level user
        if (in_array($level, ['user', 'sales'])) {
            return view('dashboard/dashboard_user'); // Halaman untuk User/Sales
        } elseif (in_array($level, ['admin', 'manager'])) {
            return view('dashboard/dashboard_admin'); // Halaman untuk Admin/Manager
        } else {
            return view('dashboard/dashboard_default'); // Jika level tidak dikenali
        }
    }


    public function getRandomData()
    {
        $subjects = [
            "Email Corporate",
            "Reset Password",
            "MS Excel bermasalah",
            "MS Word bermasalah",
            "Relokasi PC",
            "Suara Zoom tidak keluar",
            "WiFi hilang",
            "Instalasi Software"
        ];

        $team = $this->dashboardModel->getRandomTeam();

        $data = [
            "id" => rand(1, 10),
            "type" => rand(0, 1) ? "Incident" : "Request",
            "ticket" => rand(1000000, 9999999),
            "team" => $team ? $team['Wilayah'] : "N/A",
            "support" => $team ? $team['Nama'] : "N/A",
            "subject" => $subjects[array_rand($subjects)],
            "status" => rand(0, 1) ? "Assigned" : "Resolved",
            "sla" => sprintf("%d:%02d:%02d", rand(1, 5), rand(10, 59), rand(10, 59)),
            "fromAssign" => sprintf("%d:%02d:%02d", rand(1, 5), rand(10, 59), rand(10, 59)),
            "fromCreate" => sprintf("%d:%02d:%02d", rand(1, 5), rand(10, 59), rand(10, 59))
        ];

        return $this->respond($data);
    }
}

?>