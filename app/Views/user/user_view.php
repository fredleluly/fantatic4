<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Root Variables */
:root {
    --primary: #6366f1;
    --secondary: #818cf8;
    --success: #22c55e;
    --warning: #f59e0b;
    --background: #0f172a;
    --surface: #1e293b;
    --text: #ffffff;
    --border: #334155;
    --text-secondary: #94a3b8;
}

/* Reset & Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Inter', system-ui, -apple-system, sans-serif;
}

body {
    background-color: var(--background);
    color: var(--text);
    min-height: 100vh;
    display: flex;
}

/* Sidebar Styles */
.sidebar {
    background-color: var(--surface);
    width: 280px;
    height: 100vh;
    padding: 2rem 1.5rem;
    position: fixed;
    border-right: 1px solid var(--border);
}

.logo {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 2.5rem;
    padding: 0 0.75rem;
}

.logo h2 {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text);
}

.nav-menu {
    list-style: none;
}

.nav-item {
    margin-bottom: 0.5rem;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem;
    color: var(--text);
    text-decoration: none;
    border-radius: 0.5rem;
    transition: all 0.2s;
}

.nav-link:hover {
    background-color: rgba(99, 102, 241, 0.1);
    color: var(--primary);
}

/* Main Content Area */
.main-content {
    margin-left: 280px;
    padding: 2rem;
    width: calc(100% - 280px);
}

/* Header Section */
.header {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background-color: var(--surface);
    border-radius: 1rem;
    border: 1px solid var(--border);
}

.header h1 {
    font-size: 1.875rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text);
}

.header p {
    color: var(--text-secondary);
}

/* Table Section */
.table-section {
    background-color: var(--surface);
    border-radius: 1rem;
    border: 1px solid var(--border);
    padding: 1.5rem;
    margin-top: 2rem;
    overflow: hidden;
    borderColor: var(--text);
}

.table-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border);
    color : var(--text);
}

.table-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text);
}

/* Table Wrapper & Table */
.table-wrapper {
    overflow: visible; /* Menghilangkan scroll horizontal */
}

table {
    width: 100%;
    table-layout: auto; /* Biarkan kolom menyesuaikan isi */
    min-width: 100%; /* Pastikan tabel tetap melebar sesuai kebutuhan */
    border-collapse: collapse;
}

/* Table Headers & Cells */
th, td {
    white-space: normal; /* Biarkan teks wrap agar tidak melebar */
    word-wrap: break-word; /* Pastikan teks tidak keluar batas */
    text-align: left;
    color : var(--text) !important;
    padding: 12px;
}

th {
    background-color: rgba(99, 102, 241, 0.1);
    font-weight: 500;
}

/* Column Widths */
th:nth-child(1), td:nth-child(1) { width: 5%; }  /* No */
th:nth-child(2), td:nth-child(2) { width: 15%; } /* Nama */
th:nth-child(3), td:nth-child(3) { width: 12%; } /* Username */
th:nth-child(4), td:nth-child(4) { width: 10%; } /* Level */
th:nth-child(5), td:nth-child(5) { width: 10%; } /* Status */
th:nth-child(6), td:nth-child(6) { width: 15%; } /* Email */
th:nth-child(7), td:nth-child(7) { width: 15%; } /* Phone */
th:nth-child(8), td:nth-child(8) { width: 18%; } /* Aksi */

/* Table Hover Effects */
tr:hover {
    background-color: rgba(99, 102, 241, 0.05) !important;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    justify-content: flex-start;
    min-width: 140px;
}

.btn-action {
    padding: 0.4rem 0.8rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    white-space: nowrap;
    cursor: pointer;
}

.btn-edit {
    background-color: var(--warning);
    color: #000;
}

.btn-edit:hover {
    background-color: #d97706;
    color: #000;
}

.btn-delete {
    background-color: #ef4444;
    color: var(--text);
}

.btn-delete:hover {
    background-color: #dc2626;
}

/* Add User Button */
.btn-add {
    background-color: var(--primary);
    color: var(--text);
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    text-decoration: none;
    transition: all 0.2s;
}

.btn-add:hover {
    background-color: var(--secondary);
}

/* Empty State */
.empty-state {
    padding: 2rem;
    text-align: center;
    color: var(--text-secondary);
}

/* Utility Classes */
.d-flex {
    display: flex;
}

.justify-content-between {
    justify-content: space-between;
}

.align-items-center {
    align-items: center;
}

.mb-3 {
    margin-bottom: 1rem;
}

.text-center {
    text-align: center;
}

/* Remove Bootstrap Table Striping */
.table-striped > tbody > tr:nth-of-type(odd) {
    background-color: transparent !important;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .sidebar {
        width: 240px;
    }
    
    .main-content {
        margin-left: 240px;
        width: calc(100% - 240px);
    }
}

@media (max-width: 768px) {
    .header h1 {
        font-size: 1.5rem;
    }
    
    .table-section {
        padding: 1rem;
    }
    
    .btn-action {
        padding: 0.35rem 0.7rem;
        font-size: 0.8rem;
    }
}
    </style>
</head>
<body>
    <?= view('sidebar/sidebar') ?>

    <main class="main-content">
        <div class="header">
            <h1>Daftar Pengguna</h1>
            <p>Manage and view user data</p>
        </div>
        <div class="table-section">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>User List</h3>
                <a href="<?= base_url('user/create_user') ?>" class="btn btn-primary">Tambah User</a>
            </div>
            <div class="table-wrapper">
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php $no = 1; foreach ($users as $user) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= esc($user['Nama']) ?></td>
                                    <td><?= esc($user['Username']) ?></td>
                                    <td><?= esc($user['Level']) ?></td>
                                    <td><?= esc($user['Status']) ?></td>
                                    <td><?= esc($user['Email']) ?></td>
                                    <td><?= esc($user['Phone']) ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="<?= base_url('user/edit/' . $user['Username']) ?>" 
                                            class="btn-action btn-edit">
                                                Edit
                                            </a>
                                            <a href="<?= site_url('user/delete/' . $user['Username']) ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?');">Hapus</a>

                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data pengguna.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>

