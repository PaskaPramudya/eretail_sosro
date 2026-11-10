<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operasional Staff - Sosro Seller Central</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
    <style>
        :root{--nav:#131921;--nav2:#232f3e;--orange:#ff9900}
        body{background:#f3f4f6;color:#172033} .topbar{background:var(--nav);border-bottom:4px solid var(--orange)}
        .metric{background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:18px;box-shadow:0 1px 2px #0001}
        .metric small{display:block;color:#64748b}.metric strong{font-size:25px}.metric b{float:right;color:var(--orange);font-size:22px}
        .status{padding:5px 10px;border-radius:999px;font-size:11px;font-weight:700;background:#e5e7eb}
        @media(max-width:900px){.order-wrap{overflow:auto}.order-table{min-width:1000px}}
    </style>
    <body class="min-h-screen">

    <!-- Header / Navbar -->
    <header class="topbar text-white p-4 shadow-md flex justify-between items-center px-8">
        <div>
            <h1 class="text-xl font-bold">SOSRO <span class="font-normal text-gray-300">Seller Central</span></h1>
            <p class="text-xs text-gray-300">Pusat Operasional Penjualan & Pengiriman</p>
        </div>
        <a href="{{ url('/logout') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded-lg text-sm transition">Keluar</a>
    </header>

    <main class="max-w-7xl mx-auto p-6">
        <div class="flex justify-between items-end mb-5"><div><p class="text-sm text-gray-500">Dashboard / Operasional</p><h2 class="text-2xl font-bold">Pesanan Masuk & Pengiriman</h2></div><span class="text-sm text-gray-500">{{ now()->format('d M Y') }}</span></div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="metric"><b>▣</b><small>Total Pesanan</small><strong>{{ count($pesanan ?? []) }}</strong></div>
            <div class="metric"><b>◷</b><small>Menunggu Proses</small><strong>{{ collect($pesanan ?? [])->where('status_bayar', 'Pending')->count() }}</strong></div>
            <div class="metric"><b>↗</b><small>Dalam Pengiriman</small><strong>{{ collect($pesanan ?? [])->where('status_bayar', 'Dalam Pengiriman')->count() }}</strong></div>
            <div class="metric"><b>✓</b><small>Total Nilai Pesanan</small><strong>Rp {{ number_format(collect($pesanan ?? [])->sum('total_bayar'), 0, ',', '.') }}</strong></div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="order-wrap bg-white rounded-xl shadow border border-gray-200 overflow-hidden">
            <table class="order-table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-amber-200 text-amber-900 font-semibold text-sm">
                        <th class="p-3">No. Pesanan</th>
                        <th class="p-3">Nama Pembeli</th>
                        <th class="p-3">No. WA</th>
                        <th class="p-3">Metode Pengiriman</th>
                        <th class="p-3">Alamat</th>
                        <th class="p-3">Total Pembayaran</th>
                        <th class="p-3">Status Pesanan</th>
                        <th class="p-3 text-center">Aksi Operasional</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($pesanan as $item)
                    <tr class="hover:bg-amber-50/50">
                        <td class="p-3 font-semibold text-gray-800">#{{ $item->id ?? '-' }}</td>
                        <td class="p-3 font-medium text-gray-900">{{ $item->nama_pemesan ?? 'Mitra' }}</td>
                        <td class="p-3 text-gray-600">{{ $item->no_wa ?? '-' }}</td>
                        <td class="p-3 text-gray-600">{{ $item->metode_pengiriman ?? '-' }}</td>
                        <td class="p-3 text-gray-600">{{ $item->alamat ?? '-' }}</td>
                        <td class="p-3 font-semibold text-amber-800">Rp {{ number_format($item->total_bayar ?? 0, 0, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="status
                                {{ ($item->status_bayar ?? '') == 'Selesai' || ($item->status_bayar ?? '') == 'Lunas' ? 'bg-green-100 text-green-800' : '' }}
                                {{ ($item->status_bayar ?? '') == 'Dalam Pengiriman' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ ($item->status_bayar ?? '') == 'Diproses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ ($item->status_bayar ?? '') == 'Pending' ? 'bg-orange-100 text-orange-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $item->status_bayar ?? 'Pending' }}
                            </span>
                        </td>
                        <td class="p-3 text-center space-x-1 whitespace-nowrap">
                            <!-- Tombol Proses Pesanan -->
                            <form action="{{ url('/staff/proses-pesanan/' . ($item->id ?? 0)) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-amber-700 hover:bg-amber-800 text-white px-3 py-1 rounded text-xs font-semibold shadow-sm transition">Proses</button>
                            </form>
                            
                            <!-- Tombol Atur Pengiriman -->
                            <form action="{{ url('/staff/atur-pengiriman/' . ($item->id ?? 0)) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold shadow-sm transition">Kirim</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="p-6 text-center text-gray-500">Belum ada data pesanan masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
