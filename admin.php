<?php
session_start();
include 'koneksi.php';

<<<<<<< HEAD
// 1. Proses Tambah Produk Baru
if (isset($_POST['tambah_produk'])) {
    $nama_produk = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $harga = intval($_POST['harga']);
    $stok = intval($_POST['stok']);

    $nama_gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];

    if (!empty($nama_gambar)) {
        move_uploaded_file($tmp_gambar, $nama_gambar);
    } else {
        $nama_gambar = '';
    }

    $query_tambah = "INSERT INTO produk (nama_produk, kategori, harga, stok, gambar) VALUES ('$nama_produk', '$kategori', $harga, $stok, '$nama_gambar')";

    if (mysqli_query($koneksi, $query_tambah)) {
        echo "<script>alert('Produk baru berhasil ditambahkan!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan produk.');</script>";
    }
=======
// Validasi Keamanan: Mengarahkan ke pelanggan.php jika bukan admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: pelanggan.php?status=admin_login_failed");
    exit();
>>>>>>> 9d2d01970cad8ffaf74167be64b67d4287fc1a54
}

// 2. Proses Edit Nama Gambar
if (isset($_POST['edit_gambar'])) {
    $id = $_POST['id'];
    $gambar = mysqli_real_escape_string($koneksi, $_POST['gambar']);

<<<<<<< HEAD
    $query_update_gambar = "UPDATE produk SET gambar = '$gambar' WHERE id = '$id'";
    if (mysqli_query($koneksi, $query_update_gambar)) {
        echo "<script>alert('Gambar produk berhasil diperbarui!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui gambar.');</script>";
    }
}
=======
// 2. Hitung Total Pesanan & Omset
$q_pesan = mysqli_query($koneksi, "SELECT COUNT(*) as total, SUM(total_bayar) as omset FROM pesan");
$res_pesan = ($q_pesan) ? mysqli_fetch_assoc($q_pesan) : ['total' => 0, 'omset' => 0];
$total_pesanan = $res_pesan['total'] ?? 0;
$total_omset   = $res_pesan['omset'] ?? 0;
>>>>>>> 9d2d01970cad8ffaf74167be64b67d4287fc1a54

// 3. Proses Update Stok
if (isset($_POST['update_stok'])) {
    $id = $_POST['id'];
    $mode = $_POST['mode']; // 'tambah' atau 'set'
    $jumlah = intval($_POST['jumlah']);

    if ($mode == 'tambah') {
        $query = "UPDATE produk SET stok = stok + $jumlah WHERE id = '$id'";
    } else {
        $query = "UPDATE produk SET stok = $jumlah WHERE id = '$id'";
    }

<<<<<<< HEAD
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Stok barang berhasil diperbarui!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui stok.');</script>";
    }
}

// 4. Proses Hapus Produk
if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    $query_hapus = "DELETE FROM produk WHERE id = '$id_hapus'";

    if (mysqli_query($koneksi, $query_hapus)) {
        echo "<script>alert('Produk berhasil dihapus!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk.'); window.location.href='admin.php';</script>";
    }
}

// Ambil Seluruh Data Produk
$data_produk = mysqli_query($koneksi, "SELECT * FROM produk");
=======
// 5. Ambil Data Produk
$q_produk_list = mysqli_query($koneksi, "SELECT * FROM produk ORDER BY id ASC");
>>>>>>> 9d2d01970cad8ffaf74167be64b67d4287fc1a54
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - E-Retail Sosro</title>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/table.css">
    <style>
        .btn-tambah { background-color: #2980b9; color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; margin-bottom: 15px; font-weight: bold; }
        .btn-tambah:hover { background-color: #1f618d; }
        .btn-edit { background-color: #f39c12; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-edit:hover { background-color: #d68910; }
        .btn-gambar { background-color: #3498db; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-gambar:hover { background-color: #2980b9; }
        .btn-hapus { background-color: #e74c3c; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13.33px; display: inline-block; }
        .btn-hapus:hover { background-color: #c0392b; }
        .modal { display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); }
        .modal-content { background-color: #fff; margin: 5% auto; padding: 20px; width: 380px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .modal-content h3 { margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 8px; box-sizing: border-box; }
        .btn-submit { background-color: #27ae60; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
        .btn-close { background-color: #c0392b; color: white; padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; width: 100%; margin-top: 5px; }
    </style>
</head>
<body>

<div class="header">
    <h2>Dashboard Admin E-Retail Sosro</h2>
    <a href="logout_admin.php" style="color: white; float: right; margin-top: -30px;">Logout</a>
</div>

<div class="container" style="padding: 20px;">
    <h3>Daftar Produk & Kelola Stok</h3>
    
    <button class="btn-tambah" onclick="bukaModalTambah()">+ Tambah Produk Baru</button>

    <table border="1" cellspacing="0" cellpadding="10" style="width: 100%; text-align: left;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok Saat Ini</th>
                <th>File Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($data_produk)) : ?>
            <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['nama_produk']); ?></td>
                <td><?= htmlspecialchars($row['kategori']); ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><strong><?= isset($row['stok']) ? $row['stok'] : 0; ?></strong></td>
                <td><?= !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : '<i>Belum Ada</i>'; ?></td>
                <td>
                    <button class="btn-edit" onclick="bukaModalStok('<?= $row['id']; ?>', '<?= htmlspecialchars($row['nama_produk']); ?>')">Edit Stok</button>
                    <button class="btn-gambar" onclick="bukaModalGambar('<?= $row['id']; ?>', '<?= htmlspecialchars($row['nama_produk']); ?>')">Edit Gambar</button>
                    <a href="admin.php?hapus=<?= $row['id']; ?>" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Modal 1: Tambah Produk Baru -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h3>Tambah Produk Baru</h3>
        <form action="admin.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Produk:</label>
                <input type="text" name="nama_produk" required placeholder="Contoh: Susu Kedelai">
            </div>
<<<<<<< HEAD
            <div class="form-group">
                <label>Kategori:</label>
                <input type="text" name="kategori" required placeholder="Contoh: Minuman">
            </div>
            <div class="form-group">
                <label>Harga (Rp):</label>
                <input type="number" name="harga" min="0" required placeholder="Contoh: 5000">
            </div>
            <div class="form-group">
                <label>Stok Awal:</label>
                <input type="number" name="stok" min="0" required placeholder="Contoh: 50">
            </div>
            <div class="form-group">
                <label>File Gambar:</label>
                <input type="file" name="gambar" accept="image/*" required>
            </div>
            <button type="submit" name="tambah_produk" class="btn-submit">Simpan Produk</button>
            <button type="button" class="btn-close" onclick="tutupModalTambah()">Batal</button>
        </form>
    </div>
</div>

<!-- Modal 2: Edit Stok -->
<div id="modalStok" class="modal">
    <div class="modal-content">
        <h3>Kelola Stok Barang</h3>
        <form action="admin.php" method="POST">
            <input type="hidden" name="id" id="modal_stok_id">
            <div class="form-group">
                <label>Nama Produk:</label>
                <input type="text" id="modal_stok_nama" readonly style="background-color: #eee;">
            </div>
            <div class="form-group">
                <label>Pilih Aksi:</label>
                <select name="mode" required>
                    <option value="tambah">Tambah dari Stok Sekarang (+)</option>
                    <option value="set">Ubah Langsung Total Stok (=)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Barang:</label>
                <input type="number" name="jumlah" min="1" required placeholder="Masukkan jumlah">
            </div>
            <button type="submit" name="update_stok" class="btn-submit">Simpan Stok</button>
            <button type="button" class="btn-close" onclick="tutupModalStok()">Batal</button>
        </form>
    </div>
</div>

<!-- Modal 3: Edit Gambar -->
<div id="modalGambar" class="modal">
    <div class="modal-content">
        <h3>Edit Nama Gambar</h3>
        <form action="admin.php" method="POST">
            <input type="hidden" name="id" id="modal_gambar_id">
            <div class="form-group">
                <label>Nama Produk:</label>
                <input type="text" id="modal_gambar_nama" readonly style="background-color: #eee;">
            </div>
            <div class="form-group">
                <label>Nama File Gambar (termasuk ekstensi):</label>
                <input type="text" name="gambar" required placeholder="Contoh: susu_kedelai.jpg">
            </div>
            <button type="submit" name="edit_gambar" class="btn-submit">Simpan Gambar</button>
            <button type="button" class="btn-close" onclick="tutupModalGambar()">Batal</button>
        </form>
    </div>
</div>

<script>
function bukaModalTambah() { document.getElementById('modalTambah').style.display = 'block'; }
function tutupModalTambah() { document.getElementById('modalTambah').style.display = 'none'; }

function bukaModalStok(id, nama) {
    document.getElementById('modal_stok_id').value = id;
    document.getElementById('modal_stok_nama').value = nama;
    document.getElementById('modalStok').style.display = 'block';
}
function tutupModalStok() { document.getElementById('modalStok').style.display = 'none'; }

function bukaModalGambar(id, nama) {
    document.getElementById('modal_gambar_id').value = id;
    document.getElementById('modal_gambar_nama').value = nama;
    document.getElementById('modalGambar').style.display = 'block';
}
function tutupModalGambar() { document.getElementById('modalGambar').style.display = 'none'; }
</script>

=======
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
>>>>>>> 9d2d01970cad8ffaf74167be64b67d4287fc1a54
</body>
</html>