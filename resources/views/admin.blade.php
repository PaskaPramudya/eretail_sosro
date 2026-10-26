<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - E-Retail Sosro</title>
    <link rel="stylesheet" href="{{ asset('css/base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <style>
        /* Mengatur font agar lebih rapi dan modern */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fdf8f5; /* Background krem/hangat muda */
            margin: 0;
        }

        /* Styling Header ala Navbar Sosro */
        .header {
            background-color: #8c3b10 !important; /* Cokelat kemerahan hangat */
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .header h2 { margin: 0; font-size: 22px; font-weight: bold; }
        .header-btn-logout {
            background-color: #e52929; /* Merah cerah khas tombol Keluar */
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
            background-color: #eab676; /* Warna oranye muda kekuningan hangat */
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
            background-color: #e52929; /* Merah Sosro */
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