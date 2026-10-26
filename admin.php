<?php
session_start();
include 'koneksi.php';

// Validasi Keamanan: Mengarahkan ke pelanggan.php jika bukan admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: pelanggan.php?status=admin_login_failed");
    exit();
}

// 1. Hitung Total Produk
$q_produk = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk");
$total_produk = ($q_produk) ? mysqli_fetch_assoc($q_produk)['total'] : 0;

// 2. Hitung Total Pesanan & Omset
$q_pesan = mysqli_query($koneksi, "SELECT COUNT(*) as total, SUM(total_bayar) as omset FROM pesan");
$res_pesan = ($q_pesan) ? mysqli_fetch_assoc($q_pesan) : ['total' => 0, 'omset' => 0];
$total_pesanan = $res_pesan['total'] ?? 0;
$total_omset   = $res_pesan['omset'] ?? 0;

// 3. Hitung Total Pelanggan/Mitra
$q_user = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengguna WHERE role='pelanggan'");
$total_pelanggan = ($q_user) ? mysqli_fetch_assoc($q_user)['total'] : 0;

// 4. Ambil Data Pesanan Terbaru
$q_pesanan_list = mysqli_query($koneksi, "SELECT * FROM pesan ORDER BY id DESC LIMIT 10");

// 5. Ambil Data Produk
$q_produk_list = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Commerce Sosro</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col md:flex-row antialiased">
    <!-- SIDEBAR NAVIGATION -->
    <aside class="w-full md:w-64 bg-amber-900 text-white flex-shrink-0 flex flex-col justify-between shadow-xl">
        <div>
            <!-- Brand Logo Header -->
            <div class="p-5 border-b border-amber-800/80 flex items-center gap-3">
                <div class="bg-red-600 p-2 rounded-xl font-bold text-xl tracking-wide flex items-center justify-center shadow">
                    <i data-lucide="store" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h1 class="font-extrabold text-lg text-white tracking-wide">SOSRO</h1>
                    <p class="text-[10px] text-amber-200 tracking-wider uppercase font-semibold">Admin Panel</p>
                </div>
            </div>
            <!-- Nav Links -->
            <nav class="p-4 space-y-1.5 font-medium text-sm">
                <a href="admin.php" class="flex items-center gap-3 px-4 py-3 bg-amber-800 text-white rounded-xl shadow-inner font-semibold">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 text-amber-300"></i>
                    <span>Dashboard Utama</span>
                </a>
                <a href="#tabel-pesanan" class="flex items-center gap-3 px-4 py-3 text-amber-200 hover:bg-amber-800/60 hover:text-white rounded-xl transition">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span>Data Pesanan</span>
                </a>
                <a href="#tabel-produk" class="flex items-center gap-3 px-4 py-3 text-amber-200 hover:bg-amber-800/60 hover:text-white rounded-xl transition">
                    <i data-lucide="package" class="w-5 h-5"></i>
                    <span>Katalog Produk</span>
                </a>
                <a href="pelanggan.php" target="_blank" class="flex items-center gap-3 px-4 py-3 text-amber-200 hover:bg-amber-800/60 hover:text-white rounded-xl transition">
                    <i data-lucide="external-link" class="w-5 h-5"></i>
                    <span>Lihat Toko Online</span>
                </a>
            </nav>
        </div>
        <!-- Logout Footer Sidebar -->
        <div class="p-4 border-t border-amber-800/80">
            <a href="logout_admin.php" onclick="return confirm('Yakin ingin keluar dari panel admin?')" class="flex items-center justify-center gap-2 w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl text-xs transition shadow">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Keluar Akun Admin</span>
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- TOP BAR HEADER -->
        <header class="bg-white border-b border-slate-200 shadow-sm px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i data-lucide="shield-check" class="w-6 h-6 text-amber-800"></i>
                <h2 class="text-xl font-bold text-slate-900">Panel Kontrol Utama</h2>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-bold text-slate-800"><?php echo htmlspecialchars($_SESSION['admin_nama'] ?? 'Administrator'); ?></p>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase">Super Admin</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-800 text-white font-bold flex items-center justify-center text-sm shadow">
                    <?php echo strtoupper(substr($_SESSION['admin_nama'] ?? 'A', 0, 1)); ?>
                </div>
            </div>
        </header>

        <!-- MAIN BODY CONTENT -->
        <main class="p-6 overflow-y-auto space-y-8 flex-1">
            <!-- STATS CARDS GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Card 1: Total Produk -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Produk</p>
                        <h3 class="text-2xl font-extrabold text-slate-900 mt-1"><?php echo $total_produk; ?></h3>
                        <span class="text-[11px] text-amber-800 font-medium mt-1 inline-block">Varian Produk Sosro</span>
                    </div>
                    <div class="p-3.5 bg-amber-50 text-amber-800 rounded-2xl border border-amber-100">
                        <i data-lucide="package" class="w-7 h-7"></i>
                    </div>
                </div>
                <!-- Card 2: Total Pesanan -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Pesanan</p>
                        <h3 class="text-2xl font-extrabold text-slate-900 mt-1"><?php echo $total_pesanan; ?></h3>
                        <span class="text-[11px] text-emerald-600 font-medium mt-1 inline-block">Transaksi Masuk</span>
                    </div>
                    <div class="p-3.5 bg-red-50 text-red-600 rounded-2xl border border-red-100">
                        <i data-lucide="shopping-cart" class="w-7 h-7"></i>
                    </div>
                </div>
                <!-- Card 3: Total Omset -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Nilai Pesanan</p>
                        <h3 class="text-xl font-extrabold text-amber-900 mt-1">Rp <?php echo number_format($total_omset, 0, ',', '.'); ?></h3>
                        <span class="text-[11px] text-slate-400 font-medium mt-1 inline-block">Akumulasi Penjualan</span>
                    </div>
                    <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-2xl border border-emerald-100">
                        <i data-lucide="wallet" class="w-7 h-7"></i>
                    </div>
                </div>
                <!-- Card 4: Pelanggan/Mitra -->
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Mitra & Pelanggan</p>
                        <h3 class="text-2xl font-extrabold text-slate-900 mt-1"><?php echo $total_pelanggan; ?></h3>
                        <span class="text-[11px] text-slate-400 font-medium mt-1 inline-block">Akun Terdaftar</span>
                    </div>
                    <div class="p-3.5 bg-sky-50 text-sky-600 rounded-2xl border border-sky-100">
                        <i data-lucide="users" class="w-7 h-7"></i>
                    </div>
                </div>
            </div>

            <!-- TABEL 1: DATA PESANAN MASUK -->
            <div id="tabel-pesanan" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-gradient-to-r from-amber-900 to-amber-800 text-white">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="receipt" class="w-5 h-5 text-amber-300"></i>
                        <h3 class="font-bold text-base">Data Pesanan Terbaru</h3>
                    </div>
                    <span class="text-xs bg-amber-700/80 text-amber-100 px-3 py-1 rounded-full font-semibold">Live Updating</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                                <th class="py-3.5 px-4">ID</th>
                                <th class="py-3.5 px-4">Pemesan</th>
                                <th class="py-3.5 px-4">No. WA</th>
                                <th class="py-3.5 px-4">Metode</th>
                                <th class="py-3.5 px-4">Alamat</th>
                                <th class="py-3.5 px-4">Total Bayar</th>
                                <th class="py-3.5 px-4">Tanggal</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            <?php if ($q_pesanan_list && mysqli_num_rows($q_pesanan_list) > 0): ?>
                                <?php while ($p = mysqli_fetch_assoc($q_pesanan_list)): ?>
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="py-3.5 px-4 font-bold text-slate-900">#<?php echo $p['id']; ?></td>
                                        <td class="py-3.5 px-4 font-semibold text-slate-900"><?php echo htmlspecialchars($p['nama_pemesan']); ?></td>
                                        <td class="py-3.5 px-4 text-slate-600"><?php echo htmlspecialchars($p['no_wa']); ?></td>
                                        <td class="py-3.5 px-4"><span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md border border-slate-200 font-semibold"><?php echo htmlspecialchars($p['metode_pengiriman']); ?></span></td>
                                        <td class="py-3.5 px-4 max-w-xs truncate text-slate-500"><?php echo htmlspecialchars($p['alamat']); ?></td>
                                        <td class="py-3.5 px-4 font-bold text-amber-900">Rp <?php echo number_format($p['total_bayar'], 0, ',', '.'); ?></td>
                                        <td class="py-3.5 px-4 text-slate-500"><?php echo htmlspecialchars($p['tanggal']); ?></td>
                                        <td class="py-3.5 px-4 text-center">
                                            <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-1 rounded-full font-bold text-[11px]">
                                                <i data-lucide="clock" class="w-3 h-3"></i> <?php echo htmlspecialchars($p['status_bayar'] ?? 'Pending'); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-slate-400">
                                        <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 opacity-40"></i>
                                        Belum ada data pesanan masuk.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TABEL 2: KATALOG PRODUK -->
            <div id="tabel-produk" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-900 text-white">
                    <div class="flex items-center gap-2.5">
                        <i data-lucide="box" class="w-5 h-5 text-amber-400"></i>
                        <h3 class="font-bold text-base">Katalog Produk Sosro</h3>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-bold uppercase tracking-wider">
                                <th class="py-3.5 px-4">ID</th>
                                <th class="py-3.5 px-4">Nama Produk</th>
                                <th class="py-3.5 px-4">Kategori</th>
                                <th class="py-3.5 px-4">Harga Satuan</th>
                                <th class="py-3.5 px-4">Stok</th>
                                <th class="py-3.5 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                            <?php if ($q_produk_list && mysqli_num_rows($q_produk_list) > 0): ?>
                                <?php while ($prod = mysqli_fetch_assoc($q_produk_list)): ?>
                                    <tr class="hover:bg-slate-50 transition">
                                        <td class="py-3.5 px-4 font-bold text-slate-400">#<?php echo $prod['id']; ?></td>
                                        <td class="py-3.5 px-4 font-bold text-slate-900"><?php echo htmlspecialchars($prod['nama_produk']); ?></td>
                                        <td class="py-3.5 px-4"><span class="bg-amber-50 text-amber-800 border border-amber-200 px-2.5 py-0.5 rounded font-semibold"><?php echo htmlspecialchars($prod['kategori']); ?></span></td>
                                        <td class="py-3.5 px-4 font-bold text-slate-900">Rp <?php echo number_format($prod['harga'], 0, ',', '.'); ?></td>
                                        <td class="py-3.5 px-4 font-bold <?php echo ($prod['stok'] > 10 ? 'text-emerald-600' : 'text-red-600'); ?>">
                                            <?php echo $prod['stok']; ?> pcs
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <button onclick="editStok('<?php echo $prod['id']; ?>', '<?php echo htmlspecialchars($prod['nama_produk'], ENT_QUOTES); ?>', '<?php echo $prod['stok']; ?>', '<?php echo $prod['harga']; ?>')" class="inline-flex items-center gap-1 bg-amber-100 hover:bg-amber-200 text-amber-800 px-3 py-1.5 rounded-lg font-bold transition text-xs shadow-sm">
                                                <i data-lucide="edit" class="w-3.5 h-3.5"></i> Edit Stok
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-8 text-slate-400">
                                        Belum ada data produk di database.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL EDIT STOK & HARGA PRODUK -->
    <div id="modal-edit-stok" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-100">
            <div class="bg-amber-900 text-white p-4 flex justify-between items-center">
                <h3 class="font-bold text-base flex items-center gap-2">
                    <i data-lucide="package" class="w-5 h-5 text-amber-300"></i> Kelola Stok & Harga Produk
                </h3>
                <button onclick="closeEditModal()" class="hover:bg-amber-800 p-1 rounded-lg text-amber-200 hover:text-white transition">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form action="update_produk.php" method="POST" class="p-6 space-y-4">
                <input type="hidden" id="edit-id" name="id">

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Nama Produk</label>
                    <input type="text" id="edit-nama" class="w-full px-3 py-2 bg-slate-100 border border-slate-300 rounded-lg text-sm text-slate-600 font-bold focus:outline-none" readonly>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Jumlah Stok (Pcs)</label>
                    <input type="number" id="edit-stok" name="stok" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold text-emerald-700" required>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Harga Satuan (Rp)</label>
                    <input type="number" id="edit-harga" name="harga" min="0" class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500 font-bold text-slate-800" required>
                </div>

                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-medium text-slate-700 hover:bg-slate-50 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-amber-800 hover:bg-amber-900 text-white font-bold rounded-lg text-sm shadow transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT INIT & INTERAKSI -->
    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // Fungsi Buka Modal Edit Stok
        function editStok(id, nama, stok, harga) {
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-stok').value = stok;
            document.getElementById('edit-harga').value = harga;
            
            document.getElementById('modal-edit-stok').classList.remove('hidden');
            lucide.createIcons();
        }

        // Fungsi Tutup Modal Edit Stok
        function closeEditModal() {
            document.getElementById('modal-edit-stok').classList.add('hidden');
        }
    </script>
</body>
</html>