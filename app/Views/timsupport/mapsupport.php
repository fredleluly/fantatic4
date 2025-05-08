<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Support</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map { height: 500px; }
    </style>
</head>
<body>
    <h2>Map Support PLN</h2>
    <div id="map"></div>

    <script>
    var map = L.map('map').setView([-2.548926, 118.0148634], 5); // Atur view default

    // Tambahkan peta dari OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Data kantor utama dari PHP
    var kantorUtama = <?= json_encode($kantor_utama); ?>;

    // Tambahkan marker untuk setiap kantor utama
    kantorUtama.forEach(function (kantor) {
        addMarker(map, kantor.lat, kantor.lon, kantor.name);
    });

    // Fungsi untuk menambahkan marker dan event click
    function addMarker(map, lat, lon, name) {
        var marker = L.marker([lat, lon]).addTo(map);
        
        marker.on('click', function () {
            fetchWilayahData(name);
        });
    }

    // Fungsi untuk mengambil data wilayah berdasarkan marker yang diklik
    function fetchWilayahData(wilayah) {
        fetch('/map-support/getData?wilayah=' + encodeURIComponent(wilayah))
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert(data.error);
                } else {
                    updateTable(data);
                }
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Fungsi untuk memperbarui tabel dengan data yang didapat dari AJAX
    function updateTable(data) {
        let tableBody = document.getElementById('dataTableBody');
        tableBody.innerHTML = '';

        data.forEach(item => {
            let row = `<tr>
                <td>${item.id}</td>
                <td>${item.nama}</td>
                <td>${item.wilayah}</td>
                <td>${item.jabatan}</td>
            </tr>`;
            tableBody.innerHTML += row;
        });
    }
</script>

</body>
</html>
