<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operasional Staff - Sosro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800">
    <header class="border-b-4 border-orange-400 bg-slate-900 px-6 py-4 text-white shadow">
        <div class="mx-auto flex max-w-7xl items-center justify-between">
            <div>
                <h1 class="text-xl font-bold">SOSRO <span class="font-normal text-slate-300">Staff Operasional</span></h1>
                <p class="mt-1 text-xs text-slate-300">Memproses pesanan dan mengatur pengiriman</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="hidden text-sm text-slate-300 sm:inline">{{ session('nama', 'Staff') }}</span>
                <a href="{{ route('logout') }}" class="rounded bg-red-600 px-4 py-2 text-sm font-semibold hover:bg-red-700">Keluar</a>
            </div>
        </div>
    </header>

    <main class="mx-auto max-w-7xl p-4 sm:p-6">
        <div class="mb-6 flex flex-col justify-between gap-2 sm:flex-row sm:items-end">
            <div>
                <p class="text-sm text-slate-500">Dashboard / Operasional</p>
                <h2 class="text-2xl font-bold">Pesanan dan Pengiriman</h2>
                <p class="mt-1 text-sm text-slate-500">Staff hanya memproses pesanan yang pembayarannya sudah dikonfirmasi admin.</p>
            </div>
            <span class="text-sm text-slate-500">{{ now()->format('d M Y') }}</span>
        </div>

        @if(session('success'))
            <div class="mb-5 rounded-lg border border-green-300 bg-green-50 p-3 text-sm text-green-700">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-5 rounded-lg border border-red-300 bg-red-50 p-3 text-sm text-red-700">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        @php
            $items = collect($pesanan ?? []);
            $statusField = $statusColumn ?? 'status_bayar';
            $statusOf = fn ($item) => $item->{$statusField} ?? 'Pending';
        @endphp
        <section class="mb-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
            <div class="rounded-lg border bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Total Pesanan</p><strong class="text-2xl">{{ $items->count() }}</strong></div>
            <div class="rounded-lg border bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Siap Diproses</p><strong class="text-2xl text-amber-600">{{ $items->filter(fn ($item) => $statusOf($item) === 'Lunas')->count() }}</strong></div>
            <div class="rounded-lg border bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Dalam Pengiriman</p><strong class="text-2xl text-blue-600">{{ $items->filter(fn ($item) => $statusOf($item) === 'Dalam Pengiriman')->count() }}</strong></div>
            <div class="rounded-lg border bg-white p-4 shadow-sm"><p class="text-xs text-slate-500">Nilai Pesanan</p><strong class="text-lg text-slate-800">Rp {{ number_format($items->sum('total_bayar'), 0, ',', '.') }}</strong></div>
        </section>

        <div class="overflow-hidden rounded-xl border bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-[1150px] w-full text-left text-sm">
                    <thead class="bg-slate-800 text-xs uppercase text-white">
                        <tr><th class="p-3">Pesanan</th><th class="p-3">Penerima</th><th class="p-3">Kontak</th><th class="p-3">Alamat</th><th class="p-3">Total</th><th class="p-3">Status</th><th class="p-3">Pengiriman</th><th class="p-3">Aksi Staff</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200">
                    @forelse($items as $item)
                        @php $status = $statusOf($item); @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="p-3 font-semibold">#{{ $item->id }}</td>
                            <td class="p-3"><div class="font-medium">{{ $item->nama_pemesan }}</div><div class="text-xs text-slate-500">{{ $item->tanggal }}</div></td>
                            <td class="p-3">{{ $item->no_wa }}</td>
                            <td class="max-w-xs p-3">{{ $item->alamat }}</td>
                            <td class="p-3 font-semibold">Rp {{ number_format($item->total_bayar ?? 0, 0, ',', '.') }}</td>
                            <td class="p-3"><span class="rounded-full px-2.5 py-1 text-xs font-bold {{ $status === 'Selesai' ? 'bg-green-100 text-green-700' : ($status === 'Dalam Pengiriman' ? 'bg-blue-100 text-blue-700' : ($status === 'Diproses' ? 'bg-amber-100 text-amber-700' : ($status === 'Lunas' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700'))) }}">{{ $status === 'Menunggu Pembayaran' ? 'Menunggu Verifikasi Admin' : $status }}</span></td>
                            <td class="p-3"><div>{{ $item->metode_pengiriman ?: 'Belum diatur' }}</div><div class="text-xs text-slate-500">Resi: {{ $item->nomor_resi ?? 'Belum ada' }}</div></td>
                            <td class="p-3">
                                <div class="flex min-w-[220px] flex-col gap-2">
                                    @if($status === 'Lunas')
                                        <form action="{{ route('staff.proses', $item->id) }}" method="POST">@csrf<button class="w-full rounded bg-amber-600 px-3 py-2 text-xs font-semibold text-white hover:bg-amber-700">Proses Pesanan</button></form>
                                    @endif
                                    @if($status === 'Menunggu Pembayaran')
                                        <span class="text-xs font-semibold text-slate-500">Menunggu verifikasi pembayaran admin</span>
                                    @endif
                                    @if($status === 'Diproses')
                                        <form action="{{ route('staff.pengiriman', $item->id) }}" method="POST" class="space-y-2">@csrf<input name="metode_pengiriman" value="{{ $item->metode_pengiriman }}" placeholder="Jasa pengiriman" required class="w-full rounded border px-2 py-1.5 text-xs"><input name="nomor_resi" placeholder="Nomor resi (opsional)" class="w-full rounded border px-2 py-1.5 text-xs"><button class="w-full rounded bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700">Atur Pengiriman</button></form>
                                    @endif
                                    @if($status === 'Dalam Pengiriman')
                                        <form action="{{ route('staff.selesai', $item->id) }}" method="POST">@csrf<button class="w-full rounded bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700">Tandai Selesai</button></form>
                                    @endif
                                    @if($status === 'Selesai')<span class="text-xs font-semibold text-green-700">Pesanan selesai</span>@endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="p-10 text-center text-slate-500">Belum ada pesanan yang siap diproses.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
