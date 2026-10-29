<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Staff Distributor - E-Retail Sosro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Header / Navbar -->
    <header class="bg-amber-800 text-white p-4 shadow-md flex justify-between items-center px-8">
        <div>
            <h1 class="text-xl font-bold">Dashboard Staff Distributor</h1>
            <p class="text-xs text-amber-200">Operasional Penjualan & Pengiriman Barang</p>
        </div>
        <a href="{{ url('/logout') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-lg text-sm transition">Keluar</a>
    </header>

    <main class="max-w-7xl mx-auto p-6">
        <h2 class="text-xl font-bold text-amber-900 mb-4">Daftar Pesanan Masuk & Pengiriman</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-amber-200 text-amber-900 font-semibold text-sm">
                        <th class="p-3">No. Pesanan</th>
                        <th class="p-3">Nama Pembeli</th>
                        <th class="p-3">Alamat Pengiriman</th>
                        <th class="p-3">Total Pembayaran</th>
                        <th class="p-3">Status Pesanan</th>
                        <th class="p-3 text-center">Aksi Operasional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($pesanan as $item)
                    <tr class="hover:bg-amber-50/50">
                        <td class="p-3 font-semibold text-gray-800">#{{ $item->id ?? $item->id_pesanan ?? '-' }}</td>
                        <td class="p-3">{{ $item->nama_pembeli ?? $item->nama ?? 'Mitra' }}</td>
                        <td class="p-3">{{ $item->alamat ?? '-' }}</td>
                        <td class="p-3 font-semibold text-amber-800">Rp {{ number_format($item->total_harga ?? $item->total ?? 0, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold 
                                {{ ($item->status ?? '') == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                                {{ ($item->status ?? '') == 'Dalam Pengiriman' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ ($item->status ?? '') == 'Diproses' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $item->status ?? 'Menunggu Verifikasi' }}
                            </span>
                        </td>
                        <td class="p-3 text-center space-x-1">
                            <!-- Tombol Proses Pesanan -->
                            <form action="{{ url('/staff/proses-pesanan/' . ($item->id ?? $item->id_pesanan ?? 0)) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-amber-700 hover:bg-amber-800 text-white px-3 py-1 rounded text-xs font-semibold">Proses</button>
                            </form>
                            
                            <!-- Tombol Atur Pengiriman -->
                            <form action="{{ url('/staff/atur-pengiriman/' . ($item->id ?? $item->id_pesanan ?? 0)) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">Kirim</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">Belum ada data pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>