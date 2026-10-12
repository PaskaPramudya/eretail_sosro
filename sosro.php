<?php
include 'koneksi.php';

// Ambil data untuk widget statistik
$q_produk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk");
$total_produk = mysqli_fetch_assoc($q_produk)['total'] ?? 0;

$q_mitra = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM mitra");
$total_mitra = mysqli_fetch_assoc($q_mitra)['total'] ?? 0;

$q_pesan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pesan");
$total_pesan = mysqli_fetch_assoc($q_pesan)['total'] ?? 0;

$q_staff = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM staff");
$total_staff = mysqli_fetch_assoc($q_staff)['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Sosro - Dashboard Admin</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 font-sans text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Top Navigation Bar -->
    <header class="bg-amber-800 text-white shadow-md sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
                <div class="bg-red-600 p-2 rounded-lg font-bold text-xl tracking-wide flex items-center gap-2 shadow">
                    <i data-lucide="store" class="w-6 h-6"></i>
                    <span>SOSRO</span>
                </div>
                <div>
                    <h1 class="font-semibold text-lg leading-tight">Dashboard Admin</h1>
                    <p class="text-xs text-amber-200">Database: ecommers_sosro</p>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 text-sm bg-amber-900/50 px-3 py-1.5 rounded-full border border-amber-700">
                    <i data-lucide="user-check" class="w-4 h-4 text-emerald-400"></i>
                    <span>Admin Utama</span>
                </div>
                <button class="hover:bg-amber-700 p-2 rounded-full transition" title="Logout">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <div class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row gap-6">

        <!-- Sidebar Navigation -->
        <aside class="w-full md:w-64 flex-shrink-0">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sticky top-20">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-3">
                    Tabel Database
                </h2>
                
                <nav class="space-y-1">
                    <button onclick="switchTab('produk')" id="nav-produk" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition bg-amber-800 text-white shadow-sm">
                        <div class="flex items-center gap-2">
                            <i data-lucide="package" class="w-5 h-5"></i>
                            <span>Data Produk</span>
                        </div>
                        <span class="bg-amber-700 text-white text-xs font-bold px-2 py-0.5 rounded-full"><?= $total_produk ?></span>
                    </button>

                    <button onclick="switchTab('mitra')" id="nav-mitra" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-700 hover:bg-amber-50 hover:text-amber-900">
                        <div class="flex items-center gap-2">
                            <i data-lucide="handshake" class="w-5 h-5"></i>
                            <span>Data Mitra</span>
                        </div>
                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2 py-0.5 rounded-full"><?= $total_mitra ?></span>
                    </button>

                    <button onclick="switchTab('pesan')" id="nav-pesan" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-700 hover:bg-amber-50 hover:text-amber-900">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span>Data Pesan</span>
                        </div>
                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2 py-0.5 rounded-full"><?= $total_pesan ?></span>
                    </button>

                    <button onclick="switchTab('kirim')" id="nav-kirim" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-700 hover:bg-amber-50 hover:text-amber-900">
                        <div class="flex items-center gap-2">
                            <i data-lucide="truck" class="w-5 h-5"></i>
                            <span>Pengiriman</span>
                        </div>
                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2 py-0.5 rounded-full">0</span>
                    </button>

                    <button onclick="switchTab('staff')" id="nav-staff" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-700 hover:bg-amber-50 hover:text-amber-900">
                        <div class="flex items-center gap-2">
                            <i data-lucide="users" class="w-5 h-5"></i>
                            <span>Data Staff</span>
                        </div>
                        <span class="bg-amber-100 text-amber-800 text-xs font-bold px-2 py-0.5 rounded-full"><?= $total_staff ?></span>
                    </button>
                </nav>

                <div class="mt-8 pt-4 border-t border-gray-100 px-3 text-xs text-gray-500">
                    <p class="font-semibold text-gray-700">Status Server:</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>MariaDB 10.4.32</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1">

            <!-- Summary Stats Widget -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center space-x-3">
                    <div class="p-2.5 rounded-lg bg-amber-100 text-amber-800 flex-shrink-0">
                        <i data-lucide="package" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Total Produk</p>
                        <p class="text-base font-bold text-gray-800"><?= $total_produk ?> Varian</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center space-x-3">
                    <div class="p-2.5 rounded-lg bg-emerald-100 text-emerald-800 flex-shrink-0">
                        <i data-lucide="handshake" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Total Mitra</p>
                        <p class="text-base font-bold text-gray-800"><?= $total_mitra ?> Partner</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center space-x-3">
                    <div class="p-2.5 rounded-lg bg-blue-100 text-blue-800 flex-shrink-0">
                        <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Pesanan Masuk</p>
                        <p class="text-base font-bold text-gray-800"><?= $total_pesan ?> Transaksi</p>
                    </div>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex items-center space-x-3">
                    <div class="p-2.5 rounded-lg bg-purple-100 text-purple-800 flex-shrink-0">
                        <i data-lucide="user-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Staff Aktif</p>
                        <p class="text-base font-bold text-gray-800"><?= $total_staff ?> Orang</p>
                    </div>
                </div>
            </div>

            <!-- Table Card Container -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                
                <!-- Action Bar -->
                <div class="p-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gray-50/50">
                    <div>
                        <h2 id="table-title" class="text-lg font-bold text-gray-800">Tabel Produk</h2>
                        <p id="table-subtitle" class="text-xs text-gray-500">Kelola katalog produk e-commerce Sosro</p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                        <div class="relative flex-1 sm:w-64">
                            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" placeholder="Cari data..." class="w-full pl-9 pr-4 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <button onclick="openModal()" class="bg-amber-700 hover:bg-amber-800 text-white text-sm font-medium px-4 py-2 rounded-lg flex items-center gap-2 transition shadow-sm">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                            <span>Tambah Data</span>
                        </button>
                    </div>
                </div>

                <!-- Table Wrapper -->
                <div class="overflow-x-auto">

                    <!-- TABEL 1: PRODUK -->
                    <table id="table-produk" class="min-w-full divide-y divide-gray-200 text-left text-sm">
                        <thead class="bg-gray-50 text-gray-600 font-semibold uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3">ID Produk</th>
                                <th class="px-4 py-3">Nama Produk</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Harga</th>
                                <th class="px-4 py-3">Stok</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <?php
                            $data_produk = mysqli_query($koneksi, "SELECT * FROM produk");
                            if(mysqli_num_rows($data_produk) > 0) {
                                while($row = mysqli_fetch_assoc($data_produk)) {
                                    echo "<tr class='hover:bg-amber-50/40 transition'>
                                            <td class='px-4 py-3 font-mono text-xs font-semibold text-gray-600'>PRD-".$row['id']."</td>
                                            <td class='px-4 py-3 font-medium text-gray-900'>".$row['nama_produk']."</td>
                                            <td class='px-4 py-3'><span class='px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800'>Minuman</span></td>
                                            <td class='px-4 py-3 font-semibold'>Rp ".number_format($row['harga'], 0, ',', '.')."</td>
                                            <td class='px-4 py-3'>".$row['stok']." Pcs</td>
                                            <td class='px-4 py-3 text-right space-x-2'>
                                                <button class='text-amber-700 hover:text-amber-900 bg-amber-50 p-1.5 rounded'><i data-lucide='edit' class='w-4 h-4'></i></button>
                                                <button class='text-red-600 hover:text-red-800 bg-red-50 p-1.5 rounded'><i data-lucide='trash-2' class='w-4 h-4'></i></button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='px-4 py-6 text-center text-gray-400'>Belum ada data produk</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- TABEL 2: MITRA -->
                    <table id="table-mitra" class="min-w-full divide-y divide-gray-200 text-left text-sm hidden">
                        <thead class="bg-gray-50 text-gray-600 font-semibold uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3">ID Mitra</th>
                                <th class="px-4 py-3">Nama Perusahaan</th>
                                <th class="px-4 py-3">Kontak</th>
                                <th class="px-4 py-3">Wilayah</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <?php
                            $data_mitra = mysqli_query($koneksi, "SELECT * FROM mitra");
                            if(mysqli_num_rows($data_mitra) > 0) {
                                while($row = mysqli_fetch_assoc($data_mitra)) {
                                    echo "<tr class='hover:bg-amber-50/40 transition'>
                                            <td class='px-4 py-3 font-mono text-xs font-semibold text-gray-600'>MTR-".$row['id']."</td>
                                            <td class='px-4 py-3 font-medium text-gray-900'>".$row['nama_mitra']."</td>
                                            <td class='px-4 py-3'>".$row['kontak']."</td>
                                            <td class='px-4 py-3'>".$row['wilayah']."</td>
                                            <td class='px-4 py-3'><span class='px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800'>Aktif</span></td>
                                            <td class='px-4 py-3 text-right space-x-2'>
                                                <button class='text-amber-700 hover:text-amber-900 bg-amber-50 p-1.5 rounded'><i data-lucide='edit' class='w-4 h-4'></i></button>
                                                <button class='text-red-600 hover:text-red-800 bg-red-50 p-1.5 rounded'><i data-lucide='trash-2' class='w-4 h-4'></i></button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='px-4 py-6 text-center text-gray-400'>Belum ada data mitra</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- TABEL 3: PESAN -->
                    <table id="table-pesan" class="min-w-full divide-y divide-gray-200 text-left text-sm hidden">
                        <thead class="bg-gray-50 text-gray-600 font-semibold uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3">ID Pesanan</th>
                                <th class="px-4 py-3">Nama Pemesan</th>
                                <th class="px-4 py-3">No. WhatsApp</th>
                                <th class="px-4 py-3">Total Bayar</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <?php
                            $data_pesan = mysqli_query($koneksi, "SELECT * FROM pesan ORDER BY id DESC");
                            if(mysqli_num_rows($data_pesan) > 0) {
                                while($row = mysqli_fetch_assoc($data_pesan)) {
                                    echo "<tr class='hover:bg-amber-50/40 transition'>
                                            <td class='px-4 py-3 font-mono text-xs font-semibold text-gray-600'>PSN-10".$row['id']."</td>
                                            <td class='px-4 py-3 font-medium text-gray-900'>".$row['nama_pemesan']."</td>
                                            <td class='px-4 py-3'>".$row['no_wa']."</td>
                                            <td class='px-4 py-3 font-semibold'>Rp ".number_format($row['total_bayar'], 0, ',', '.')."</td>
                                            <td class='px-4 py-3'><span class='px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800'>".$row['status_bayar']."</span></td>
                                            <td class='px-4 py-3 text-right space-x-2'>
                                                <button class='text-amber-700 hover:text-amber-900 bg-amber-50 p-1.5 rounded'><i data-lucide='edit' class='w-4 h-4'></i></button>
                                                <button class='text-red-600 hover:text-red-800 bg-red-50 p-1.5 rounded'><i data-lucide='trash-2' class='w-4 h-4'></i></button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6' class='px-4 py-6 text-center text-gray-400'>Belum ada pesanan masuk dari pelanggan</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- TABEL 4: KIRIM -->
                    <table id="table-kirim" class="min-w-full divide-y divide-gray-200 text-left text-sm hidden">
                        <thead class="bg-gray-50 text-gray-600 font-semibold uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3">ID Pengiriman</th>
                                <th class="px-4 py-3">ID Pesanan</th>
                                <th class="px-4 py-3">Armada</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <tr><td colspan='5' class='px-4 py-6 text-center text-gray-400'>Belum ada data pengiriman</td></tr>
                        </tbody>
                    </table>

                    <!-- TABEL 5: STAFF -->
                    <table id="table-staff" class="min-w-full divide-y divide-gray-200 text-left text-sm hidden">
                        <thead class="bg-gray-50 text-gray-600 font-semibold uppercase text-xs tracking-wider">
                            <tr>
                                <th class="px-4 py-3">ID Staff</th>
                                <th class="px-4 py-3">Nama Staff</th>
                                <th class="px-4 py-3">Jabatan</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            <?php
                            $data_staff = mysqli_query($koneksi, "SELECT * FROM staff");
                            if(mysqli_num_rows($data_staff) > 0) {
                                while($row = mysqli_fetch_assoc($data_staff)) {
                                    echo "<tr class='hover:bg-amber-50/40 transition'>
                                            <td class='px-4 py-3 font-mono text-xs font-semibold text-gray-600'>STF-0".$row['id']."</td>
                                            <td class='px-4 py-3 font-medium text-gray-900'>".$row['nama_staff']."</td>
                                            <td class='px-4 py-3'>".$row['jabatan']."</td>
                                            <td class='px-4 py-3 text-right space-x-2'>
                                                <button class='text-amber-700 hover:text-amber-900 bg-amber-50 p-1.5 rounded'><i data-lucide='edit' class='w-4 h-4'></i></button>
                                                <button class='text-red-600 hover:text-red-800 bg-red-50 p-1.5 rounded'><i data-lucide='trash-2' class='w-4 h-4'></i></button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='px-4 py-6 text-center text-gray-400'>Belum ada data staff</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>

                <!-- Footer Pagination -->
                <div class="p-4 border-t border-gray-200 flex flex-col sm:flex-row justify-between items-center text-xs text-gray-500 gap-3">
                    <span>Menampilkan data terdaftar di Database</span>
                    <div class="flex space-x-1">
                        <button class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition">Prev</button>
                        <button class="px-3 py-1 rounded border border-amber-800 bg-amber-800 text-white font-medium">1</button>
                        <button class="px-3 py-1 rounded border border-gray-300 bg-white text-gray-600 hover:bg-gray-50 transition">Next</button>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Script Tab Switcher -->
    <script>
        lucide.createIcons();

        function switchTab(tableName) {
            const tables = ['produk', 'mitra', 'pesan', 'kirim', 'staff'];
            
            tables.forEach(t => {
                document.getElementById(`table-${t}`).classList.add('hidden');
                const navBtn = document.getElementById(`nav-${t}`);
                navBtn.className = 'w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition text-gray-700 hover:bg-amber-50 hover:text-amber-900';
            });

            document.getElementById(`table-${tableName}`).classList.remove('hidden');
            const activeNav = document.getElementById(`nav-${tableName}`);
            activeNav.className = 'w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition bg-amber-800 text-white shadow-sm';

            const titleMap = {
                'produk': { title: 'Tabel Produk', subtitle: 'Kelola katalog produk e-commerce Sosro' },
                'mitra': { title: 'Tabel Mitra', subtitle: 'Daftar mitra bisnis & distributor resmi' },
                'pesan': { title: 'Tabel Pesanan (Pesan)', subtitle: 'Riwayat transaksi pesanan produk' },
                'kirim': { title: 'Tabel Pengiriman (Kirim)', subtitle: 'Status ekspedisi & kurir logistik' },
                'staff': { title: 'Tabel Staff Admin', subtitle: 'Hak akses & kelola anggota pengelola' }
            };

            document.getElementById('table-title').textContent = titleMap[tableName].title;
            document.getElementById('table-subtitle').textContent = titleMap[tableName].subtitle;
        }
    </script>
</body>
</html>