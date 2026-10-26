<?php
session_start();
include 'koneksi.php';

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
}

// 2. Proses Edit Nama Gambar
if (isset($_POST['edit_gambar'])) {
    $id = $_POST['id'];
    $gambar = mysqli_real_escape_string($koneksi, $_POST['gambar']);

    $query_update_gambar = "UPDATE produk SET gambar = '$gambar' WHERE id = '$id'";
    if (mysqli_query($koneksi, $query_update_gambar)) {
        echo "<script>alert('Gambar produk berhasil diperbarui!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui gambar.');</script>";
    }
}

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

</body>
</html>