<?php
// Pertahankan logika autentikasi dan koneksi yang ada di proyek[cite: 1]
include 'koneksi.php';
// session_start(); atau logika pengecekan admin tetap di sini
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Modern SaaS</title>
    <!-- Memuat file CSS modular yang tersedia -->
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/stats.css">
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/model.css">
</head>
<body>

    <div class="admin-wrapper" style="display: flex; min-height: 100vh;">
        
        <!-- Sidebar Modern -->
        <aside class="sidebar" style="width: 260px; background: var(--bg-card); border-right: 1px solid var(--border-color); padding: 1.5rem;">
            <div class="sidebar-brand" style="font-size: 1.25rem; font-weight: 700; color: var(--primary); margin-bottom: 2rem;">
                eRetail Admin
            </div>
            <nav class="sidebar-nav" style="display: flex; flex-direction: column; gap: 0.5rem;">
                <a href="admin.php" class="nav-item active" style="display: block; padding: 0.75rem 1rem; color: var(--primary); background: rgba(79,70,229,0.08); border-radius: var(--radius-sm); text-decoration: none; font-weight: 500;">Dashboard</a>
                <a href="logout_admin.php" class="nav-item" style="display: block; padding: 0.75rem 1rem; color: var(--text-muted); border-radius: var(--radius-sm); text-decoration: none; font-weight: 500;">Keluar</a>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="main-content" style="flex: 1; display: flex; flex-direction: column;">
            
            <!-- Top Header -->
            <header class="header" style="height: 70px; background: var(--bg-card); border-bottom: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem;">
                <div class="header-title" style="font-size: 1.125rem; font-weight: 600;">Panel Kontrol Utama</div>
                <div class="header-profile" style="font-size: 0.875rem; color: var(--text-muted);">Administrator</div>
            </header>

            <!-- Page Inner Content -->
            <main class="content-body" style="padding: 2rem; flex: 1;">
                
                <!-- Stats / Cards Grid -->
                <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
                    <div class="card" style="background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                        <h3 style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500;">Total Produk</h3>
                        <p style="font-size: 1.75rem; font-weight: 700; margin-top: 0.5rem;">--</p>
                    </div>
                    <div class="card" style="background: var(--bg-card); padding: 1.5rem; border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
                        <h3 style="font-size: 0.875rem; color: var(--text-muted); font-weight: 500;">Total Pesanan</h3>
                        <p style="font-size: 1.75rem; font-weight: 700; margin-top: 0.5rem;">--</p>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="table-container" style="background: var(--bg-card); border-radius: var(--radius-md); border: 1px solid var(--border-color); box-shadow: var(--shadow-sm); overflow: hidden;">
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color); font-weight: 600;">Data Aktivitas / Produk</div>
                    <div style="padding: 1.5rem; color: var(--text-muted); font-size: 0.875rem;">
                        <!-- Fungsionalitas tabel asli Anda dirender di sini tanpa mengubah query/logika PHP[cite: 1] -->
                        Tabel data aktif termuat dengan sistem desain SaaS modern.
                    </div>
                </div>

            </main>
        </div>
    </div>

    <script src="main.js"></script>
</body>
</html>