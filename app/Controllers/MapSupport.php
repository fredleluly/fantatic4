<?php
namespace App\Controllers;

use App\Models\TimSupportModel;
use App\Controllers\BaseController;

class MapSupport extends BaseController
{
    public function index()
    {
        $model = new TimSupportModel();
        
        // Data kantor utama
        $kantor_utama = [
            ["name" => "PLN UID Aceh", "lat" => 5.548290, "lon" => 95.323753],
            ["name" => "PLN PUSAT", "lat" => -6.186486, "lon" => 106.830071],
            ["name" => "PLN UID Bali Dan Nusra", "lat" => -8.670458, "lon" => 115.212631],
            ["name" => "PLN UID Banten", "lat" => -6.120000, "lon" => 106.150276],
            ["name" => "PLN Indonesia Power", "lat" => -6.236957, "lon" => 106.824453],
            ["name" => "PLN UID Jabar", "lat" => -6.914744, "lon" => 107.609810],
            ["name" => "PLN UID Jatim", "lat" => -7.536064, "lon" => 112.238401],
            ["name" => "PLN UID Jateng & DIY", "lat" => -7.800000, "lon" => 110.360000],
            ["name" => "PLN UID Kalselteng", "lat" => -3.316694, "lon" => 114.590111],
            ["name" => "PLN UID Sumsel", "lat" => -3.319437, "lon" => 104.914565]
        ];

        // Menyiapkan data per Wilayah
        $data_per_daerah = [];
        foreach ($kantor_utama as $kantor) {
            $daerah = $kantor['name'];
            $search_term = "%" . trim(str_ireplace(['PLN UID', 'PLN'], "", $daerah)) . "%";
            $data_per_daerah[$daerah] = $model->like('Wilayah', $search_term)->findAll();
        }

        return view('timsupport/mapsupport', [
            'kantor_utama' => $kantor_utama,
            'data_per_daerah' => $data_per_daerah
        ]);
    }

    public function getData()
    {
        $model = new TimSupportModel();
        $Wilayah = $this->request->getGet('Wilayah');

        if (!$Wilayah) {
            return $this->response->setJSON(["error" => "Wilayah tidak ditemukan"]);
        }

        $search_term = "%" . trim(str_ireplace(['PLN UID', 'PLN'], "", $Wilayah)) . "%";
        $data = $model->like('Wilayah', $search_term)->findAll();

        if (empty($data)) {
            return $this->response->setJSON(["error" => "Data tidak ditemukan"]);
        }

        return $this->response->setJSON($data);
    }
}
