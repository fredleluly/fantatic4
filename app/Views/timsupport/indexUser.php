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

    </script>
</body>
</html>