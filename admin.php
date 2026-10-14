
<?php
session_start();

if (empty($_SESSION['admin_login'])) {
    header("Location: login_admin.php");
    exit;
}

require 'koneksi.php';

// Ambil daftar produk dari database
$result = mysqli_query(
    $koneksi,
    "SELECT * FROM produk ORDER BY id DESC"
);

if (!$result) {
    die("Gagal mengambil data produk: " . mysqli_error($koneksi));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin E-Commerce Sosro</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 30px;
        }

        h1 { color: #b51f24; }

        form, table {
            background: white;
            padding: 15px;
            margin-bottom: 25px;
        }

        input, select, button {
            padding: 10px;
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #b51f24;
            color: white;
        }

        button {
            background: #b51f24;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h1>Dashboard Admin Sosro</h1>

<p>
    Selamat datang,
    <?= htmlspecialchars($_SESSION['admin_username'] ?? 'Admin') ?>!
</p>

<a href="logout_admin.php">Logout</a>

<h2>Tambah Produk</h2>

<form action="simpan_produk.php" method="POST">
    <label>Nama Produk</label><br>
    <input type="text" name="nama_produk" required><br>

    <label>Kategori</label><br>
    <select name="kategori" required>
        <option value="Teh Botol Sosro">Teh Botol Sosro</option>
        <option value="Fruit Tea">Fruit Tea</option>
        <option value="TEBS Sparkling">TEBS Sparkling</option>
        <option value="Minuman">Minuman Lainnya</option>
    </select><br>

    <label>Harga (Rp)</label><br>
    <input type="number" name="harga" min="0" required><br>

    <label>Stok</label><br>
    <input type="number" name="stok" min="0" required><br>

    <button type="submit">Simpan Produk</button>
</form>

<h2>Daftar Produk</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
    </tr>

    <?php while ($p = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?= (int)$p['id'] ?></td>
        <td><?= htmlspecialchars($p['nama_produk']) ?></td>
        <td><?= htmlspecialchars($p['kategori']) ?></td>
        <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
        <td><?= (int)$p['stok'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
