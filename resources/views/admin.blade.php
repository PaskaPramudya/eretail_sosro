<<<<<<< HEAD:admin.php
<?php
session_start();
include 'koneksi.php';

// --- Memeriksa dan menambahkan kolom 'gambar' jika belum ada ---
$cek_kolom = mysqli_query($koneksi, "SHOW COLUMNS FROM produk LIKE 'gambar'");
if (mysqli_num_rows($cek_kolom) == 0) {
    mysqli_query($koneksi, "ALTER TABLE produk ADD COLUMN gambar VARCHAR(255) NULL AFTER stok");
}


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
        echo "<script>window.location.href='admin.php?status=tambah_sukses';</script>";
    } else {
        echo "<script>window.location.href='admin.php?status=tambah_gagal';</script>";
    }
}

// 2. Proses Edit Nama Gambar
if (isset($_POST['edit_gambar'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $gambar = mysqli_real_escape_string($koneksi, $_POST['gambar']);

    $query_update_gambar = "UPDATE produk SET gambar = '$gambar' WHERE id = '$id'";
    if (mysqli_query($koneksi, $query_update_gambar)) {
        echo "<script>window.location.href='admin.php?status=gambar_sukses';</script>";
    } else {
        echo "<script>window.location.href='admin.php?status=gambar_gagal';</script>";
    }
}

// 3. Proses Update Stok
if (isset($_POST['update_stok'])) {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $mode = $_POST['mode']; // 'tambah' atau 'set'
    $jumlah = intval($_POST['jumlah']);

    if ($mode == 'tambah') {
        $query = "UPDATE produk SET stok = stok + $jumlah WHERE id = '$id'";
    } else {
        $query = "UPDATE produk SET stok = $jumlah WHERE id = '$id'";
    }

    if (mysqli_query($koneksi, $query)) {
        echo "<script>window.location.href='admin.php?status=stok_sukses';</script>";
    } else {
        echo "<script>window.location.href='admin.php?status=stok_gagal';</script>";
    }
}

// 4. Proses Hapus Produk
if (isset($_GET['hapus'])) {
    $id_hapus = intval($_GET['hapus']);
    
    $query_hapus = "DELETE FROM produk WHERE id = '$id_hapus'";

    if (mysqli_query($koneksi, $query_hapus)) {
        echo "<script>window.location.href='admin.php?status=hapus_sukses';</script>";
    } else {
        echo "<script>window.location.href='admin.php?status=hapus_gagal';</script>";
    }
}

// Ambil Seluruh Data Produk
$data_produk = mysqli_query($koneksi, "SELECT * FROM produk");
?>

=======
>>>>>>> 440da6656413722635c3849a1852a5a0f6cb366a:resources/views/admin.blade.php
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - E-Retail Sosro</title>
<<<<<<< HEAD:admin.php
    <!-- SweetAlert2 CDN untuk Notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/sidebar.css">
    <link rel="stylesheet" href="css/table.css">
=======
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
>>>>>>> 440da6656413722635c3849a1852a5a0f6cb366a:resources/views/admin.blade.php
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fdf8f5;
            margin: 0;
        }

        /* Styling Header ala Navbar Sosro */
        .header {
            background-color: #8c3b10 !important;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .header h2 { margin: 0; font-size: 22px; font-weight: bold; }
        .header-btn-logout {
            background-color: #e52929;
            color: white !important;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s;
        }
        .header-btn-logout:hover { background-color: #c91f1f; }

        /* Styling Container & Table */
        .container {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }
        h3 { color: #5a2707; margin-bottom: 20px; }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
            border: none;
        }
        thead tr {
            background-color: #eab676;
            color: #5a2707;
            text-align: left;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0e4db;
        }
        tbody tr:hover { background-color: #fff9f2; }

        /* Styling Tombol Aksi */
        .btn-tambah { 
            background-color: #e52929;
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            margin-bottom: 20px; 
            font-weight: bold; 
            box-shadow: 0 2px 5px rgba(229, 41, 41, 0.3);
            transition: 0.2s;
        }
        .btn-tambah:hover { background-color: #c91f1f; }
        
        .btn-edit { background-color: #e67e22; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; transition: 0.2s; font-size: 13px;}
        .btn-edit:hover { background-color: #d35400; }
        
        .btn-gambar { background-color: #8c3b10; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; transition: 0.2s; font-size: 13px;}
        .btn-gambar:hover { background-color: #692c0c; }
        
        .btn-hapus { background-color: #c0392b; color: white; padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; display: inline-block; transition: 0.2s;}
        .btn-hapus:hover { background-color: #922b21; }

        /* Styling Modal */
        .modal { display: none; position: fixed; z-index: 999; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(60, 20, 0, 0.6); }
        .modal-content { 
            background-color: #fff; 
            margin: 8% auto; 
            padding: 25px; 
            width: 400px; 
            border-radius: 10px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.2); 
            border-top: 5px solid #e52929;
        }
        .modal-content h3 { margin-top: 0; color: #8c3b10; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 6px; font-weight: 500; color: #444; }
        .form-group input, .form-group select { 
            width: 100%; 
            padding: 10px; 
            box-sizing: border-box; 
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fafafa;
        }
        .form-group input:focus, .form-group select:focus { outline: none; border-color: #e52929; }
        
        .btn-submit { background-color: #27ae60; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-weight: bold; margin-bottom: 8px;}
        .btn-submit:hover { background-color: #219150; }
        .btn-close { background-color: #95a5a6; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; width: 100%; font-weight: bold;}
        .btn-close:hover { background-color: #7f8c8d; }
    </style>
</head>
<body>

<div class="header">
    <h2>Dashboard Admin E-Retail</h2>
    <a href="{{ url('/logout') }}" class="header-btn-logout">Keluar</a>
</div>

<div class="container">
    <h3>Daftar Produk & Kelola Stok</h3>
    
    <button class="btn-tambah" onclick="bukaModalTambah()">+ Tambah Produk Baru</button>

    <table cellspacing="0" cellpadding="10">
        <thead>
            <tr>
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
<<<<<<< HEAD:admin.php
            <?php while ($row = mysqli_fetch_assoc($data_produk)) : ?>
            <?php 
                $id_produk = $row['id'];
            ?>
            <tr>
                <td><?= $id_produk; ?></td>
                <td><strong><?= htmlspecialchars($row['nama_produk']); ?></strong></td>
                <td><?= htmlspecialchars($row['kategori']); ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td><span style="background-color: #ffe8d6; padding: 3px 8px; border-radius: 4px; color: #d35400; font-weight: bold;"><?= isset($row['stok']) ? $row['stok'] : 0; ?></span></td>
                <td><?= !empty($row['gambar']) ? htmlspecialchars($row['gambar']) : '<i style="color:#aaa;">Belum Ada</i>'; ?></td>
                <td>
                    <button class="btn-edit" onclick="bukaModalStok('<?= $id_produk; ?>', '<?= htmlspecialchars(addslashes($row['nama_produk'])); ?>')">Edit Stok</button>
                    <button class="btn-gambar" onclick="bukaModalGambar('<?= $id_produk; ?>', '<?= htmlspecialchars(addslashes($row['nama_produk'])); ?>')">Edit Gambar</button>
                    <!-- Perubahan tombol Hapus untuk memicu popup konfirmasi modern -->
                    <a href="javascript:void(0);" class="btn-hapus" onclick="konfirmasiHapus(<?= $id_produk; ?>)">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
=======
            @if(isset($data_produk) && count($data_produk) > 0)
                @foreach ($data_produk as $row)
                @php 
                    $id_produk = $row->id ?? $row->id_produk ?? 0;
                @endphp
                <tr>
                    <td>{{ $id_produk }}</td>
                    <td><strong>{{ $row->nama_produk }}</strong></td>
                    <td>{{ $row->kategori }}</td>
                    <td>Rp {{ number_format($row->harga, 0, ',', '.') }}</td>
                    <td><span style="background-color: #ffe8d6; padding: 3px 8px; border-radius: 4px; color: #d35400; font-weight: bold;">{{ $row->stok ?? 0 }}</span></td>
                    <td>
                        @if(!empty($row->gambar))
                            {{ $row->gambar }}
                        @else
                            <i style="color:#aaa;">Belum Ada</i>
                        @endif
                    </td>
                    <td>
                        <button class="btn-edit" onclick="bukaModalStok('{{ $id_produk }}', '{{ addslashes($row->nama_produk) }}')">Edit Stok</button>
                        <button class="btn-gambar" onclick="bukaModalGambar('{{ $id_produk }}', '{{ addslashes($row->nama_produk) }}')">Edit Gambar</button>
                        <a href="{{ url('/admin/hapus/' . $id_produk) }}" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>
                </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" style="text-align: center; color: #888;">Belum ada data produk.</td>
                </tr>
            @endif
>>>>>>> 440da6656413722635c3849a1852a5a0f6cb366a:resources/views/admin.blade.php
        </tbody>
    </table>
</div>

<!-- Modal 1: Tambah Produk Baru -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h3>Tambah Produk Baru</h3>
        <form action="{{ url('/admin/tambah') }}" method="POST" enctype="multipart/form-data">
            @csrf
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
        <form action="{{ url('/admin/update-stok') }}" method="POST">
            @csrf
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
        <form action="{{ url('/admin/edit-gambar') }}" method="POST">
            @csrf
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
// Fungsi untuk membuka & menutup Modal HTML standar
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

// Fungsi SweetAlert untuk Konfirmasi Hapus
function konfirmasiHapus(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Produk yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'admin.php?hapus=' + id;
        }
    })
}

// Fungsi SweetAlert untuk Notifikasi Sukses/Gagal setelah Halaman di-Reload
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status) {
        let title = '';
        let text = '';
        let icon = 'success'; // Default icon

        switch(status) {
            case 'tambah_sukses':
                title = 'Berhasil!';
                text = 'Produk baru berhasil ditambahkan.';
                break;
            case 'tambah_gagal':
                title = 'Gagal!';
                text = 'Gagal menambahkan produk baru.';
                icon = 'error';
                break;
            case 'gambar_sukses':
                title = 'Berhasil!';
                text = 'Gambar produk berhasil diperbarui.';
                break;
            case 'gambar_gagal':
                title = 'Gagal!';
                text = 'Gagal memperbarui gambar produk.';
                icon = 'error';
                break;
            case 'stok_sukses':
                title = 'Berhasil!';
                text = 'Stok barang berhasil diperbarui.';
                break;
            case 'stok_gagal':
                title = 'Gagal!';
                text = 'Gagal memperbarui stok barang.';
                icon = 'error';
                break;
            case 'hapus_sukses':
                title = 'Terhapus!';
                text = 'Produk berhasil dihapus dari sistem.';
                break;
            case 'hapus_gagal':
                title = 'Gagal!';
                text = 'Gagal menghapus produk.';
                icon = 'error';
                break;
        }

        if(title !== '') {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                showConfirmButton: false,
                timer: 2000,
                backdrop: `rgba(0,0,0,0.4)`
            }).then(() => {
                // Menghilangkan parameter status dari URL agar alert tidak muncul lagi jika di-refresh
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }
    }
}
</script>

</body>
</html>