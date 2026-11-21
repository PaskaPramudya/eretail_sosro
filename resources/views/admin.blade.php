<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - E-Retail Sosro</title>
    <style>
        :root { --navy: #131921; --navy-light: #232f3e; --orange: #ff9900; --line: #e5e7eb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f3f4f6; color: #172033; font-family: Arial, sans-serif; }
        .header { display: flex; justify-content: space-between; align-items: center; padding: 16px 30px; color: #fff; background: var(--navy); border-bottom: 4px solid var(--orange); }
        .header h1 { margin: 0; font-size: 20px; }
        .header p { margin: 5px 0 0; color: #cbd5e1; font-size: 12px; }
        .logout { padding: 9px 14px; border: 1px solid #64748b; border-radius: 5px; color: #fff; text-decoration: none; font-size: 13px; }
        .container { max-width: 1400px; margin: auto; padding: 28px 30px 50px; }
        .page-title { margin: 0 0 18px; font-size: 26px; }
        .alert { margin-bottom: 18px; padding: 12px 14px; border-radius: 6px; background: #dcfce7; color: #166534; }
        .error { margin-bottom: 18px; padding: 12px 14px; border-radius: 6px; background: #fee2e2; color: #991b1b; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat { padding: 18px; background: #fff; border: 1px solid var(--line); border-radius: 8px; box-shadow: 0 1px 2px #0000000b; }
        .stat small { display: block; margin-bottom: 8px; color: #64748b; }
        .stat strong { font-size: 24px; }
        .toolbar { display: flex; justify-content: space-between; gap: 12px; align-items: center; margin-bottom: 14px; }
        .search { width: 300px; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 5px; }
        button, .button { display: inline-block; padding: 9px 12px; border: 0; border-radius: 5px; color: #fff; cursor: pointer; text-decoration: none; font-size: 13px; }
        .primary { background: var(--orange); color: #111; }
        .blue { background: #2563eb; }
        .brown { background: #8c3b10; }
        .red { background: #dc2626; }
        .green { background: #16a34a; }
        .table-wrap { overflow-x: auto; background: #fff; border: 1px solid var(--line); border-radius: 8px; }
        table { width: 100%; min-width: 900px; border-collapse: collapse; }
        th, td { padding: 13px 15px; border-bottom: 1px solid var(--line); text-align: left; vertical-align: middle; }
        th { color: #fff; background: var(--navy-light); }
        tr:last-child td { border-bottom: 0; }
        .stock { display: inline-block; padding: 4px 8px; border-radius: 12px; background: #ffedd5; color: #9a3412; font-weight: bold; }
        .actions { display: flex; flex-wrap: wrap; gap: 6px; }
        .modal { display: none; position: fixed; inset: 0; z-index: 10; padding: 30px 15px; overflow-y: auto; background: #0008; }
        .modal.open { display: block; }
        .modal-card { width: min(440px, 100%); margin: 5vh auto 0; padding: 22px; background: #fff; border-radius: 8px; }
        .modal-card h2 { margin-top: 0; }
        label { display: block; margin: 11px 0 5px; font-weight: bold; font-size: 13px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 5px; }
        .modal-actions { display: flex; gap: 8px; margin-top: 18px; }
        .modal-actions button { flex: 1; }
        .muted { color: #64748b; }
        @media (max-width: 800px) { .stats { grid-template-columns: repeat(2, 1fr); } .toolbar { align-items: stretch; flex-direction: column; } .search { width: 100%; } .container { padding: 20px 12px; } }
    </style>
</head>
<body>
    <header class="header">
        <div>
            <h1>SOSRO - Dashboard Admin</h1>
            <p>Manajemen produk, inventaris, dan harga</p>
        </div>
        <a class="logout" href="{{ route('logout') }}">Keluar</a>
    </header>

    <main class="container">
        <h2 class="page-title">Daftar Produk dan Kelola Stok</h2>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="error">
                <strong>Data belum dapat disimpan:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $produk = collect($data_produk ?? []);
            $totalProduk = $produk->count();
            $produkAktif = $produk->where('stok', '>', 0)->count();
            $stokMenipis = $produk->where('stok', '<=', 10)->count();
            $nilaiInventaris = $produk->sum(fn ($item) => ((float) ($item->harga ?? 0)) * ((int) ($item->stok ?? 0)));
        @endphp

        <section class="stats">
            <div class="stat"><small>Total Produk</small><strong>{{ $totalProduk }}</strong></div>
            <div class="stat"><small>Produk Tersedia</small><strong>{{ $produkAktif }}</strong></div>
            <div class="stat"><small>Stok Menipis</small><strong>{{ $stokMenipis }}</strong></div>
            <div class="stat"><small>Nilai Inventaris</small><strong>Rp {{ number_format($nilaiInventaris, 0, ',', '.') }}</strong></div>
        </section>

        <div class="toolbar">
            <input class="search" id="productSearch" type="search" placeholder="Cari nama atau kategori...">
            <button class="primary" type="button" onclick="openModal('modalTambah')">+ Tambah Produk</button>
        </div>

        <div class="table-wrap">
            <table id="productTable">
                <thead>
                    <tr>
                        <th>ID</th><th>Nama Produk</th><th>Kategori</th><th>Harga</th><th>Stok</th><th>Gambar</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $product)
                        <tr class="product-row">
                            <td>{{ $product->id }}</td>
                            <td><strong>{{ $product->nama_produk }}</strong></td>
                            <td>{{ $product->kategori }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td><span class="stock">{{ $product->stok }}</span></td>
                            <td>{{ $product->gambar ?: 'Belum ada' }}</td>
                            <td>
                                <div class="actions">
                                    <button class="blue" type="button" onclick="openStock({{ $product->id }}, @js($product->nama_produk))">Stok</button>
                                    <button class="brown" type="button" onclick="openImage({{ $product->id }}, @js($product->nama_produk), @js($product->gambar))">Gambar</button>
                                    <button class="green" type="button" onclick="openPrice({{ $product->id }}, @js($product->nama_produk), {{ (float) $product->harga }})">Harga</button>
                                    <a class="red button" href="{{ route('admin.products.destroy', $product->id) }}" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="muted">Belum ada data produk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <div class="modal" id="modalTambah">
        <div class="modal-card">
            <h2>Tambah Produk</h2>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Nama Produk</label><input name="nama_produk" required>
                <label>Kategori</label><input name="kategori" required>
                <label>Harga</label><input name="harga" type="number" min="0" required>
                <label>Stok Awal</label><input name="stok" type="number" min="0" required>
                <label>Gambar</label><input name="gambar" type="file" accept=".jpg,.jpeg,.png" required>
                <div class="modal-actions"><button class="green" type="submit">Simpan</button><button class="red" type="button" onclick="closeModal('modalTambah')">Batal</button></div>
            </form>
        </div>
    </div>

    <div class="modal" id="modalStok">
        <div class="modal-card">
            <h2>Perbarui Stok</h2>
            <form action="{{ route('admin.products.updateStok') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="stockId">
                <label>Produk</label><input id="stockName" readonly>
                <label>Mode</label><select name="mode"><option value="tambah">Tambah dari stok sekarang</option><option value="set">Tetapkan jumlah stok</option></select>
                <label>Jumlah</label><input name="jumlah" type="number" min="1" required>
                <div class="modal-actions"><button class="green" type="submit">Simpan</button><button class="red" type="button" onclick="closeModal('modalStok')">Batal</button></div>
            </form>
        </div>
    </div>

    <div class="modal" id="modalGambar">
        <div class="modal-card">
            <h2>Perbarui Gambar</h2>
            <form action="{{ route('admin.products.editGambar') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="imageId">
                <label>Produk</label><input id="imageName" readonly>
                <label>Nama file gambar</label><input name="gambar" id="imageFile" required>
                <div class="modal-actions"><button class="green" type="submit">Simpan</button><button class="red" type="button" onclick="closeModal('modalGambar')">Batal</button></div>
            </form>
        </div>
    </div>

    <div class="modal" id="modalHarga">
        <div class="modal-card">
            <h2>Perbarui Harga</h2>
            <form action="{{ route('admin.products.editHarga') }}" method="POST">
                @csrf
                <input type="hidden" name="id" id="priceId">
                <label>Produk</label><input id="priceName" readonly>
                <label>Harga Baru</label><input name="harga" id="priceValue" type="number" min="0" required>
                <div class="modal-actions"><button class="green" type="submit">Simpan</button><button class="red" type="button" onclick="closeModal('modalHarga')">Batal</button></div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) { document.getElementById(id).classList.add('open'); }
        function closeModal(id) { document.getElementById(id).classList.remove('open'); }
        function openStock(id, name) { document.getElementById('stockId').value = id; document.getElementById('stockName').value = name; openModal('modalStok'); }
        function openImage(id, name, image) { document.getElementById('imageId').value = id; document.getElementById('imageName').value = name; document.getElementById('imageFile').value = image || ''; openModal('modalGambar'); }
        function openPrice(id, name, price) { document.getElementById('priceId').value = id; document.getElementById('priceName').value = name; document.getElementById('priceValue').value = price; openModal('modalHarga'); }
        document.querySelectorAll('.modal').forEach((modal) => modal.addEventListener('click', (event) => { if (event.target === modal) modal.classList.remove('open'); }));
        document.getElementById('productSearch').addEventListener('input', function () {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll('.product-row').forEach((row) => { row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none'; });
        });
    </script>
</body>
</html>
