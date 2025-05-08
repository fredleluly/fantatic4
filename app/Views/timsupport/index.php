<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tim Support PLN</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        :root {
            --primary-color: #60a5fa;
            --primary-hover: rgba(96, 165, 250, 0.3);
            --primary-light: rgba(96, 165, 250, 0.2);
            --secondary-color: #34d399;
            --dark-bg: #0f172a;
            --dark-bg-alt: #1e293b;
            --sidebar-bg: #2c3e50;
            --border-light: rgba(255, 255, 255, 0.1);
            --card-bg: rgba(255, 255, 255, 0.03);
            --card-border: rgba(255, 255, 255, 0.05);
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--dark-bg) 0%, var(--dark-bg-alt) 100%);
            color: #ffffff;
            display: flex;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Layout Components */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            padding: 2rem 1.5rem;
            position: fixed;
            height: 100vh;
            z-index: 10;
            overflow-y: auto;
            transition: transform 0.3s ease;
            border-right: 1px solid var(--border-light);
        }

        .main-content {
            flex: 1;
            width: calc(100% - var(--sidebar-width));
            margin-left: var(--sidebar-width);
            padding: 2rem;
            transition: width 0.3s ease, margin-left 0.3s ease;
        }

        /* Sidebar Components */
        .logo {
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-light);
            text-align: center;
        }

        .logo h2 {
            margin: 0;
            font-size: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-light);
        }

        .profile-icon {
            margin-right: 10px;
            font-size: 24px;
        }

        .user-details span {
            font-size: 14px;
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .nav-item {
            margin: 8px 0;
        }

        .nav-link {
            display: block;
            padding: 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: var(--border-light);
        }

        /* Header Components */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem;
            background: var(--card-bg);
            border-radius: 16px;
            border: 1px solid var(--card-border);
        }

        .title {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 30px rgba(96, 165, 250, 0.3);
        }

        /* Table Components */
        .table-wrapper {
            background: var(--card-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 1.5rem;
            border: 1px solid var(--card-border);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            margin-bottom: 1rem;
            width: 100%;
        }

        .table-container {
            overflow-x: auto;
            width: 100%;
        }

        .data-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table th, .data-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--border-light);
            text-align: left;
        }

        .data-table th {
            background: rgba(255, 255, 255, 0.05);
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        .data-table tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        /* Pagination Components */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding: 1rem;
            background: var(--card-bg);
            border-radius: 10px;
            border: 1px solid var(--card-border);
        }

        .pagination-info {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .pagination-controls {
            display: flex;
            gap: 0.5rem;
        }

        .pagination-button {
            background: var(--primary-light);
            color: #fff;
            border: 1px solid rgba(96, 165, 250, 0.5);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .pagination-button:hover {
            background: var(--primary-hover);
        }

        .pagination-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .pagination-numbers {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .page-number {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid var(--border-light);
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .page-number.active {
            background: var(--primary-hover);
            border-color: rgba(96, 165, 250, 0.5);
        }

        .page-number:hover:not(.active) {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Map Components */
        #map { 
            height: 400px; 
            width: 100%; 
            border-radius: 10px;
            margin-bottom: 2rem;
            border: 1px solid var(--card-border);
            overflow: hidden;
        }

        .map-container {
            margin-bottom: 2rem;
        }

        .map-title {
            margin-bottom: 1rem;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
        }

        /* Mobile Toggle */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: var(--primary-light);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.5rem;
            z-index: 20;
            cursor: pointer;
        }

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .title {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }

            .sidebar {
                transform: translateX(-100%);
                width: 250px;
            }

            .sidebar.active {
                transform: translateX(0);
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            }

            .main-content {
                width: 100%;
                margin-left: 0;
                padding: 1.5rem;
            }

            .header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .title {
                font-size: 1.8rem;
            }

            .pagination-container {
                flex-direction: column;
                gap: 1rem;
                align-items: center;
            }

            .pagination-numbers {
                order: -1;
            }
        }

        @media (max-width: 480px) {
            .title {
                font-size: 1.5rem;
            }
            
            .table-wrapper {
                padding: 1rem;
            }
            
            .data-table th, .data-table td {
                padding: 0.75rem;
                font-size: 0.9rem;
            }

            .pagination-numbers {
                gap: 0.25rem;
            }

            .page-number {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            #map {
                height: 300px;
            }
        }
        .search-box {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
/* Action buttons */
.table-actions {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 1rem;
}

.action-button {
    background: var(--primary-color);
    color: #fff;
    border: none;
    padding: 0.6rem 1.2rem;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
}

.action-button:hover {
    background: rgba(96, 165, 250, 0.8);
}

.edit-btn, .delete-btn {
    background: transparent;
    border: none;
    color: #fff;
    padding: 0.4rem;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.edit-btn {
    color: var(--primary-color);
}

.edit-btn:hover {
    background: rgba(96, 165, 250, 0.2);
}

.delete-btn {
    color: #f87171;
}

.delete-btn:hover {
    background: rgba(248, 113, 113, 0.2);
}

/* Modal styles - untuk ditambahkan ke CSS yang sudah ada */
.modal-backdrop {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    color : #fff;
}

.modal-backdrop.active {
    opacity: 1;
    visibility: visible;
}

.modal {
    background: var(--dark-bg-alt);
    border-radius: 12px;
    width: 500px;
    max-width: 90%;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    transform: translateY(-20px);
    transition: all 0.3s ease;
}

.modal-backdrop.active .modal {
    transform: translateY(0);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-light);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: #fff;
}

.modal-close {
    background: transparent;
    border: none;
    color: rgba(255, 255, 255, 0.6);
    font-size: 1.5rem;
    cursor: pointer;
    transition: color 0.2s ease;
}

.modal-close:hover {
    color: #fff;
}

.modal-body {
    padding: 1.5rem;
    max-height: 70vh;
    overflow-y: auto;
}

.form-group {
    margin-bottom: 1.2rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9);
}

.form-control {
    width: 100%;
    padding: 0.8rem;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid var(--border-light);
    border-radius: 6px;
    color: #fff;
    font-family: inherit;
    font-size: 1rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 2px rgba(96, 165, 250, 0.2);
}

.form-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border-light);
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}

    </style>
</head>
<body>
    <!-- Mobile menu toggle -->
    <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <h2>IT Support PLN</h2>
        </div>
        
        <!-- User Profile Section -->
        <div class="user-info">
            <div class="profile-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <div class="user-details">
                <span><?= session()->get('Username') ?? 'Guest' ?></span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?= base_url('dashboard') ?>" class="nav-link">
                        <i class="fas fa-tachometer-alt fa-fw"></i> Dashboard
                    </a>
                </li>
                <?php if (session()->get('Level') === 'admin') : ?>
        <li class="nav-item">
            <a href="<?= base_url('user') ?>" class="nav-link">
                <i class="fas fa-users fa-fw"></i> User
            </a>
        </li>
        <?php endif; ?>
                <li class="nav-item">
                    <a href="<?= base_url('timsupport') ?>" class="nav-link">
                        <i class="fas fa-headset fa-fw"></i> Team
                    </a>
                </li>
              
                <li class="nav-item">
                    <a href="<?= base_url('logout') ?>" class="nav-link">
                        <i class="fas fa-sign-out-alt fa-fw"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1 class="title">Data Tim Support</h1>
        </div>

        <!-- Map Section -->
        <div class="map-container">
            <h3 class="map-title">Peta Tim Support</h3>
            <div id="map"></div>
        </div>

        <!-- Table Section -->
        <div class="table-wrapper">
            <div class="table-actions">
        <button id="addNewBtn" class="action-button"><i class="fas fa-plus"></i> Tambah Tim Support</button>
    </div>
    <!-- Search Box -->
    <input type="text" id="searchInput" placeholder="Cari Nama atau Wilayah..." class="search-box">
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Wilayah</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Username</th>
                            <th>Status</th>
                            <th>Penempatan</th>
                            <th>Aksi</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php 
                        $index = 0;
                        foreach ($timsupport as $item): 
                            $index++;
                            $page = floor(($index - 1) / 20) + 1;
                        ?>
                            <tr class="table-row" data-page="<?= $page ?>" <?= $page > 1 ? 'style="display: none;"' : '' ?>>
                                <td><?= $index ?></td>
                                <td><?= esc($item['Wilayah']) ?></td>
                                <td><?= esc($item['Nama']) ?></td>
                                <td><?= esc($item['Jabatan']) ?></td>
                                <td><?= esc($item['Username']) ?></td>
                                <td><?= esc($item['Status']) ?></td>
                                <td><?= esc($item['Penempatan']) ?></td>
                                <td>
                <button class="edit-btn" data-id="<?= $item['No'] ?>"><i class="fas fa-edit"></i></button>
                <button class="delete-btn" data-id="<?= $item['No'] ?>"><i class="fas fa-trash"></i></button>
            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Controls -->
        <div class="pagination-container">
            <div class="pagination-info">
                Showing <span id="startItem">1</span> to <span id="endItem">20</span> of <span id="totalItems"><?= count($timsupport) ?></span> entries
            </div>
            
            <div class="pagination-controls">
                <button id="prevPage" class="pagination-button" disabled>
                    <i class="fas fa-chevron-left"></i> Previous
                </button>
                
                <div class="pagination-numbers" id="paginationNumbers">
                    <!-- Pagination numbers will be inserted here via JavaScript -->
                </div>
                
                <button id="nextPage" class="pagination-button">
                    Next <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
<div class="modal-backdrop" id="formModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Tambah Tim Support</h3>
            <button class="modal-close" id="closeFormModal">&times;</button>
        </div>
        <form id="timSupportForm">
            <input type="hidden" id="timId" name="id" value="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="wilayah" class="form-label">Wilayah</label>
                    <select id="wilayah" name="wilayah" class="form-control form-select" required>
                        <option value="">Pilih Wilayah</option>
                        <option value="KALBAR">KALBAR</option>
                        <option value="ACEH">ACEH</option>
                        <option value="JATENG & DIY">JATENG & DIY</option>
                        <option value="JAKARTA 1">JAKARTA 1</option>
                        <option value="KALTIMRA">KALTIMRA</option>
                        <option value="JATIM">JATIM</option>
                        <option value="JAKARTA 2">JAKARTA 2</option>
                        <option value="JABAR">JABAR</option>
                        <option value="KALSELTENG">KALSELTENG</option>
                        <option value="BANTEN">BANTEN</option>
                        <option value="SULSELBAR">SULSELBAR</option>
                        <option value="RIAU">RIAU</option>
                        <option value="SUMUT">SUMUT</option>
                        <option value="SUMSEL">SUMSEL</option>
                        <option value="BALI DAN NUSRA">BALI DAN NUSRA</option>
                        <option value="LAMPUNG">LAMPUNG</option>
                        <option value="MALUKU">MALUKU</option>
                        <option value="PAPUA">PAPUA</option>
                        <option value="SUMBAR - JAMBI">SUMBAR - JAMBI</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" id="nama" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" id="jabatan" name="jabatan" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" name="status" class="form-control form-select" required>
                        <option value="">Pilih Status</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="penempatan" class="form-label">Penempatan</label>
                    <input type="text" id="penempatan" name="penempatan" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelFormBtn">Batal</button>
                <button type="submit" class="btn btn-primary" id="saveFormBtn">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal-backdrop" id="deleteModal">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Konfirmasi Hapus</h3>
            <button class="modal-close" id="closeDeleteModal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Apakah Anda yakin ingin menghapus Tim Support ini?</p>
            <p id="deleteItemName" class="font-bold mt-2"></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelDeleteBtn">Batal</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Hapus</button>
        </div>
    </div>
</div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <script>
        // Initialize Map
        const map = L.map('map').setView([-2.5, 118], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Marker Data for Regions
        const markersData = [
            { wilayah: "KALBAR", coordinates: [-0.0226, 109.3347] },
            { wilayah: "ACEH", coordinates: [5.5502, 95.3193] },
            { wilayah: "JATENG & DIY", coordinates: [-7.150975, 110.140259] },
            { wilayah: "JAKARTA 1", coordinates: [-6.2088, 106.8456] },
            { wilayah: "KALTIMRA", coordinates: [0.5387, 116.4194] },
            { wilayah: "JATIM", coordinates: [-7.2504, 112.7688] },
            { wilayah: "JAKARTA 2", coordinates: [-6.4025, 106.7942] },
            { wilayah: "JABAR", coordinates: [-6.9147, 107.6098] },
            { wilayah: "KALSELTENG", coordinates: [-3.3208, 114.5908] },
            { wilayah: "BANTEN", coordinates: [-6.4058, 106.0640] },
            { wilayah: "SULSELBAR", coordinates: [-5.1477, 119.4327] },
            { wilayah: "RIAU", coordinates: [0.5071, 101.4478] },
            { wilayah: "SUMUT", coordinates: [3.5970, 98.6781] },
            { wilayah: "SUMSEL", coordinates: [-2.9909, 104.7567] },
            { wilayah: "BALI DAN NUSRA", coordinates: [-8.3405, 115.0919] },
            { wilayah: "LAMPUNG", coordinates: [-5.4500, 105.2667] },
            { wilayah: "MALUKU", coordinates: [-3.6561, 128.1906] },
            { wilayah: "PAPUA", coordinates: [-4.2699, 138.0803] },
            { wilayah: "SUMBAR - JAMBI", coordinates: [-0.9492, 100.3543] }
        ];

        // Add Markers to Map
        markersData.forEach(item => {
            L.marker(item.coordinates)
                .addTo(map)
                .bindPopup(`<b>${item.wilayah}</b>`)
                .on('click', function () {
                    loadTableData(item.wilayah);
                });
        });

        // Load Table Data Function
        function loadTableData(wilayah) {
            $.ajax({
                url: '<?= base_url('timsupport/get-data') ?>',
                type: 'GET',
                data: { wilayah: wilayah },
                success: function(response) {
                    // Filter table to show only the selected region
                    const rows = document.querySelectorAll('.table-row');
                    rows.forEach(row => {
                        const regionCell = row.querySelector('td:nth-child(2)');
                        if (regionCell && regionCell.textContent === wilayah) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                    
                    // Update pagination info
                    updatePaginationInfo();
                }
            });
        }
        

        // Toggle Sidebar on Mobile
        document.getElementById('menuToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });

        // Close Sidebar When Clicking Outside on Mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const menuToggle = document.getElementById('menuToggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !menuToggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Adjust Layout on Window Resize
        window.addEventListener('resize', function() {
            const sidebar = document.getElementById('sidebar');
            if (window.innerWidth > 768 && sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');
            }
        });

        // Pagination Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const rowsPerPage = 20;
            const rows = document.querySelectorAll('.table-row');
            const totalRows = rows.length;
            const totalPages = Math.ceil(totalRows / rowsPerPage);
            
            let currentPage = 1;
            
            // Initialize pagination elements
            const paginationNumbers = document.getElementById('paginationNumbers');
            const startItem = document.getElementById('startItem');
            const endItem = document.getElementById('endItem');
            const totalItems = document.getElementById('totalItems');
            const prevPageBtn = document.getElementById('prevPage');
            const nextPageBtn = document.getElementById('nextPage');
            
            totalItems.textContent = totalRows;
            
            // Create pagination numbers
            function createPaginationNumbers() {
                paginationNumbers.innerHTML = '';
                
                // Determine range of page numbers to show
                let startPage = Math.max(1, currentPage - 2);
                let endPage = Math.min(totalPages, currentPage + 2);
                
                // Always show at least 5 pages if available
                if (endPage - startPage < 4 && totalPages > 4) {
                    if (currentPage < 3) {
                        endPage = Math.min(5, totalPages);
                    } else if (currentPage > totalPages - 2) {
                        startPage = Math.max(1, totalPages - 4);
                    }
                }
                
                // Add first page if not included in range
                if (startPage > 1) {
                    addPageNumber(1);
                    if (startPage > 2) {
                        addEllipsis();
                    }
                }
                
                // Add page numbers in range
                for (let i = startPage; i <= endPage; i++) {
                    addPageNumber(i);
                }
                
                // Add last page if not included in range
                if (endPage < totalPages) {
                    if (endPage < totalPages - 1) {
                        addEllipsis();
                    }
                    addPageNumber(totalPages);
                }
            }
            
            function addPageNumber(pageNum) {
                const pageNumber = document.createElement('div');
                pageNumber.classList.add('page-number');
                if (pageNum === currentPage) {
                    pageNumber.classList.add('active');
                }
                pageNumber.textContent = pageNum;
                pageNumber.addEventListener('click', function() {
                    goToPage(pageNum);
                });
                paginationNumbers.appendChild(pageNumber);
            }
            
            function addEllipsis() {
                const ellipsis = document.createElement('div');
                ellipsis.textContent = '...';
                ellipsis.style.padding = '0 8px';
                paginationNumbers.appendChild(ellipsis);
            }
            
            // Show rows for current page
            function displayRows() {
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                
                let visibleCount = 0;
                
                rows.forEach((row, index) => {
                    if (row.style.display !== 'none') {
                        visibleCount++;
                        if (visibleCount > start && visibleCount <= end) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });
                
                // Update pagination info
                updatePaginationInfo();
                
                // Update button states
                prevPageBtn.disabled = currentPage === 1;
                nextPageBtn.disabled = currentPage === totalPages;
                
                // Update pagination numbers
                createPaginationNumbers();
            }
            
            function updatePaginationInfo() {
                const visibleRows = Array.from(rows).filter(row => row.style.display !== 'none').length;
                const start = (currentPage - 1) * rowsPerPage + 1;
                const end = Math.min(start + rowsPerPage - 1, visibleRows);
                
                startItem.textContent = visibleRows > 0 ? start : 0;
                endItem.textContent = end;
                totalItems.textContent = visibleRows;
            }
            
            function goToPage(page) {
                currentPage = page;
                displayRows();
            }
            
            // Event listeners for pagination buttons
            prevPageBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    goToPage(currentPage - 1);
                }
            });
            
            nextPageBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    goToPage(currentPage + 1);
                }
            });
            
            // Initialize pagination
            createPaginationNumbers();
            displayRows();
        });
        document.getElementById("searchInput").addEventListener("keyup", function() {
    let filter = this.value.toUpperCase();
    let rows = document.querySelectorAll(".table-row");

    rows.forEach(row => {
        let wilayah = row.cells[1].textContent.toUpperCase();
        let nama = row.cells[2].textContent.toUpperCase();

        if (wilayah.includes(filter) || nama.includes(filter)) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    });
});

// CRUD Operations
document.addEventListener('DOMContentLoaded', function() {
    // DOM Elements
    const addNewBtn = document.getElementById('addNewBtn');
    const formModal = document.getElementById('formModal');
    const deleteModal = document.getElementById('deleteModal');
    const closeFormModal = document.getElementById('closeFormModal');
    const closeDeleteModal = document.getElementById('closeDeleteModal');
    const cancelFormBtn = document.getElementById('cancelFormBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
    const timSupportForm = document.getElementById('timSupportForm');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const modalTitle = document.getElementById('modalTitle');
    
    let currentDeleteId = null;
    
    // Open Add Modal
    addNewBtn.addEventListener('click', function() {
        modalTitle.textContent = 'Tambah Tim Support';
        timSupportForm.reset();
        document.getElementById('timId').value = '';
        formModal.classList.add('active');
    });
    
    // Open Edit Modal
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-btn')) {
            const btn = e.target.closest('.edit-btn');
            const id = btn.dataset.id;
            modalTitle.textContent = 'Edit Tim Support';
            
            // Fetch data and populate form
            fetch(`<?= base_url('timsupport/get-single') ?>/${id}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('timId').value = data.id;
                    document.getElementById('wilayah').value = data.Wilayah;
                    document.getElementById('nama').value = data.Nama;
                    document.getElementById('jabatan').value = data.Jabatan;
                    document.getElementById('username').value = data.Username;
                    document.getElementById('status').value = data.Status;
                    document.getElementById('penempatan').value = data.Penempatan;
                    
                    formModal.classList.add('active');
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    });
    
    // Open Delete Modal
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-btn')) {
            const btn = e.target.closest('.delete-btn');
            const id = btn.dataset.id;
            currentDeleteId = id;
            
            // Get the name from the row
            const row = btn.closest('tr');
            const name = row.cells[2].textContent;
            document.getElementById('deleteItemName').textContent = name;
            
            deleteModal.classList.add('active');
        }
    });
    
    // Close Modals
    closeFormModal.addEventListener('click', () => formModal.classList.remove('active'));
    closeDeleteModal.addEventListener('click', () => deleteModal.classList.remove('active'));
    cancelFormBtn.addEventListener('click', () => formModal.classList.remove('active'));
    cancelDeleteBtn.addEventListener('click', () => deleteModal.classList.remove('active'));
    
    // Close Modal on Outside Click
    window.addEventListener('click', function(e) {
        if (e.target === formModal) {
            formModal.classList.remove('active');
        }
        if (e.target === deleteModal) {
            deleteModal.classList.remove('active');
        }
    });
    
    // Submit Form
    timSupportForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = document.getElementById('timId').value;
        const url = id ? 
            `<?= base_url('timsupport/update') ?>/${id}` : 
            `<?= base_url('timsupport/create') ?>`;
        
        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                formModal.classList.remove('active');
                // Reload the page to show updated data
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    });
    
    // Confirm Delete
    confirmDeleteBtn.addEventListener('click', function() {
        if (currentDeleteId) {
            fetch(`<?= base_url('timsupport/delete') ?>/${currentDeleteId}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    deleteModal.classList.remove('active');
                    // Reload the page to show updated data
                    window.location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    });
});

    </script>
</body>
</html>