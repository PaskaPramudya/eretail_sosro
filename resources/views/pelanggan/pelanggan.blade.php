<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Commerce E-Retail Sosro - Toko Online Resmi</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 CDN untuk Animasi Centang Hijau & Silang Merah -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <style>
   :root { --amazon-navy:#131921; --amazon-blue:#232f3e; }
   body { background:#eaeded !important; }
   header { background:var(--amazon-navy) !important; border-bottom:4px solid #ff9900; }
   header .bg-red-600 { background:#e52929 !important; }
   header .bg-amber-700 { background:var(--amazon-blue) !important; }
   .amazon-card { box-shadow:0 2px 6px rgba(15,23,42,.10) !important; border-radius:8px !important; }
   .amazon-card:hover { box-shadow:0 5px 14px rgba(15,23,42,.18) !important; }
   .amazon-price { color:#b12704 !important; }
  .fly-item {
    position: fixed;
    z-index: 9999;
    width: 50px;
    height: 50px;
    object-fit: contain;
    border-radius: 50%;
    background-color: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    pointer-events: none;
    transition: all 0.8s cubic-bezier(0.18, 0.89, 0.32, 1.28);
  }

  @keyframes cartBounce {
    0% { transform: scale(1); }
    50% { transform: scale(1.3); }
    100% { transform: scale(1); }
  }

  .cart-bounce {
    animation: cartBounce 0.4s ease-in-out;
  }
</style>
  </head>

  <body class="bg-gray-50 font-sans text-gray-800 antialiased flex flex-col min-h-screen">
    <!-- Top Announcement Bar -->
    <div class="bg-amber-900 text-amber-100 text-xs py-2 px-4 text-center font-medium">
      🍃 Nikmati Keharuman & Kesegaran Teh Asli Indonesia. Bebas Ongkir untuk Pembelian Grosir Mitra!
    </div>

    <!-- Header Navigation -->
    <header class="bg-amber-800 text-white shadow-md sticky top-0 z-30">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <!-- Logo Brand -->
        <div class="flex items-center space-x-3">
          <div class="bg-red-600 p-2 rounded-lg font-bold text-xl tracking-wide flex items-center gap-2 shadow">
            <i data-lucide="store" class="w-6 h-6"></i>
            <span>SOSRO</span>
          </div>
          <span class="text-xs bg-amber-700/60 text-amber-200 px-2.5 py-1 rounded-full font-medium hidden sm:inline-block">Official Store</span>
        </div>

        <!-- Search Bar -->
        <div class="hidden md:flex flex-1 max-w-md mx-8">
          <div class="relative w-full">
            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input
              type="text"
              id="product-search" placeholder="Cari Teh Botol, Fruit Tea, TEBS..."
              class="w-full pl-9 pr-4 py-2 bg-white text-gray-800 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-inner"
            />
          </div>
        </div>

        <!-- User Actions & Cart -->
        <div class="flex items-center space-x-4">
          <button
            onclick="{{ session()->has('nama') ? 'toggleCart()' : 'requireLogin()' }}"
            class="relative bg-amber-700 hover:bg-amber-600 p-2.5 rounded-full transition flex items-center gap-2"
          >
            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
            <span
              id="cart-count"
              class="bg-red-600 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center -top-1 -right-1 absolute"
              >0</span
            >
          </button>

          <div class="h-6 w-px bg-amber-700 hidden sm:block"></div>

          <!-- Tombol Profil / Auth -->
          @if (session()->has('nama'))
            <div class="flex items-center gap-2">
              <span class="text-sm font-semibold bg-amber-900/60 px-3 py-1.5 rounded-lg border border-amber-600/50 flex items-center gap-2 text-amber-100">
                <i data-lucide="user" class="w-4 h-4 text-amber-300"></i>
                {{ session('nama') }}
              </span>
              <a href="{{ url('/logout') }}" class="text-xs font-semibold bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition shadow-sm">
                Keluar
              </a>
            </div>
          @else
            <button
              onclick="openAuthModal()"
              class="text-sm font-medium hover:text-amber-200 transition hidden sm:block cursor-pointer bg-amber-900/40 hover:bg-amber-900 px-3 py-1.5 rounded-lg border border-amber-600/50"
            >
              Masuk / Daftar
            </button>
          @endif
        </div>
      </div>
    </header>

    <!-- Hero Banner dengan Gambar Background -->
    <section 
      class="relative bg-cover bg-center text-white py-14 px-4 sm:px-6 lg:px-8"
      style="background-image: url('{{ asset('images/background.jpg') }}');"
    >
      <!-- Overlay hitam transparan -->
      <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px]"></div>

      <div class="relative max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8 z-10">
        <div class="space-y-4 text-center md:text-left max-w-xl">
          <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider drop-shadow">Promo Mitra & Grosir</span>
          <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight drop-shadow-md">
            Segarnya Minuman Asli Sosro Langsung Dari Pabrik!
          </h1>
          <p class="text-amber-100 text-sm sm:text-base drop-shadow">
            Pesan beragam produk Teh Botol Sosro, Fruit Tea, TEBS, dan Prima langsung untuk kebutuhan toko, cafe, maupun konsumsi harian Anda.
          </p>
          <div class="pt-2 flex flex-wrap justify-center md:justify-start gap-3">
            <a href="#katalog" class="bg-white text-amber-900 hover:bg-amber-100 font-bold px-6 py-3 rounded-lg shadow transition text-sm">Lihat Katalog</a>
            <a href="#cara-pesan" class="bg-amber-950/70 hover:bg-amber-900 border border-amber-500 font-medium px-5 py-3 rounded-lg transition text-sm backdrop-blur-sm">Panduan Mitra</a>
          </div>
        </div>

        <div class="w-full md:w-auto flex justify-center">
          <div class="bg-black/40 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center space-y-2 shadow-lg">
            <i data-lucide="shield-check" class="w-12 h-12 text-amber-300 mx-auto"></i>
            <p class="font-bold text-lg">100% Produk Original</p>
            <p class="text-xs text-amber-100">Jaminan Kualitas & Kadaluarsa Panjang</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content (Katalog Produk) -->
    <main id="katalog" class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1">
      <!-- Filter Category Tabs -->
      <div class="flex flex-wrap items-center justify-between gap-4 mb-8 border-b border-gray-200 pb-4">
        <div>
          <h2 class="text-2xl font-bold text-gray-900">Katalog Produk</h2>
          <p class="text-xs text-gray-500">Pilih ragam produk kesegaran Sosro favorit Anda</p>
        </div>

        <div class="flex flex-wrap gap-2">
           <button onclick="filterCatalog('all', this)" class="category-btn px-4 py-2 rounded-full text-xs font-semibold bg-amber-800 text-white shadow-sm">Semua Produk</button>
           <button onclick="filterCatalog('teh botol', this)" class="category-btn px-4 py-2 rounded-full text-xs font-semibold bg-white border border-gray-300 text-gray-700 hover:bg-amber-50 transition">Teh Botol Sosro</button>
           <button onclick="filterCatalog('fruit tea', this)" class="category-btn px-4 py-2 rounded-full text-xs font-semibold bg-white border border-gray-300 text-gray-700 hover:bg-amber-50 transition">Fruit Tea</button>
           <button onclick="filterCatalog('tebs', this)" class="category-btn px-4 py-2 rounded-full text-xs font-semibold bg-white border border-gray-300 text-gray-700 hover:bg-amber-50 transition">TEBS Sparkling</button>
        </div>
      </div>

      <!-- Product Grid Dinamis -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @if(isset($data_produk) && count($data_produk) > 0)
          @foreach ($data_produk as $row)
            @php 
              $file_gambar = !empty($row->gambar) ? asset('images/' . $row->gambar) : asset('images/Fruit Tea Apel 350ml.jpg'); 
              $stok_tersedia = $row->stok ?? 0;
              $id_produk = $row->id ?? $row->id_produk ?? 0;
            @endphp
            <div class="amazon-card bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col group product-card" data-search="{{ strtolower($row->nama_produk . ' ' . $row->kategori) }}">
              <div class="bg-gray-100 h-48 flex items-center justify-center p-4 relative overflow-hidden">
                @if (strtolower($row->kategori) == 'minuman' && $id_produk == 1)
                  <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded z-10">Terlaris</span>
                @elseif (str_contains(strtolower($row->nama_produk), 'tebs'))
                  <span class="absolute top-3 left-3 bg-amber-600 text-white text-[10px] font-bold px-2 py-0.5 rounded z-10">Sparkling</span>
                @endif

                <img
                  src="{{ $file_gambar }}"
                  alt="{{ $row->nama_produk }}"
                  class="w-full h-full object-contain group-hover:scale-110 transition transform duration-300"
                />
              </div>

              <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
                <div>
                  <span class="text-[11px] font-medium text-amber-800 uppercase tracking-wider">
                    {{ $row->kategori }}
                  </span>

                  <h3 class="font-bold text-gray-900 text-base leading-snug">
                    {{ $row->nama_produk }}
                  </h3>

                  <p class="text-xs text-emerald-600 font-semibold mt-1">
                    Stok Tersedia: {{ $stok_tersedia }}
                  </p>
                </div>

                <div class="pt-2 border-t border-gray-100 flex items-center justify-between">
                  <div>
                    <p class="text-xs text-gray-400">Harga Satuan</p>
                    <p class="amazon-price text-lg font-bold text-amber-900">Rp {{ number_format($row->harga, 0, ',', '.') }}</p>
                  </div>

                  @if (session()->has('nama'))
                  <button
                    onclick="addToCart(event, {{ $id_produk }}, '{{ addslashes($row->nama_produk) }}', {{ $row->harga }}, this, {{ $stok_tersedia }})"
                    class="bg-amber-800 hover:bg-amber-900 text-white p-2.5 rounded-lg transition shadow-sm"
                    title="Tambah ke Keranjang"
                  >
                    <i data-lucide="plus" class="w-5 h-5"></i>
                  </button>
                  @else
                    <button
                      onclick="requireLogin()"
                      class="bg-amber-800 hover:bg-amber-900 text-white p-2.5 rounded-lg transition shadow-sm"
                    >
                      <i data-lucide="plus" class="w-5 h-5"></i>
                    </button>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="col-span-full text-center py-10 text-gray-500">
            Belum ada produk yang tersedia.
          </div>
        @endif
      </div>
    </main>

    <!-- Slide-over Drawer Keranjang Belanja -->
    <div id="cart-drawer" class="fixed inset-0 z-50 overflow-hidden hidden">
      <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="toggleCart()"></div>
      <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
        <div class="w-screen max-w-md bg-white shadow-xl flex flex-col">
          <div class="p-4 bg-amber-800 text-white flex justify-between items-center">
            <div class="flex items-center gap-2">
              <i data-lucide="shopping-cart" class="w-5 h-5"></i>
              <h2 class="font-bold text-lg">Keranjang Belanja</h2>
            </div>
            <button onclick="toggleCart()" class="hover:bg-amber-700 p-1 rounded transition">
              <i data-lucide="x" class="w-5 h-5"></i>
            </button>
          </div>

          <div id="daftar-keranjang" class="flex-1 overflow-y-auto p-4 space-y-4"></div>

          <div class="p-4 border-t border-gray-200 bg-gray-50 space-y-3">
            <div class="flex justify-between text-sm font-semibold">
              <span>Total Pembelian</span>
              <span id="total-pembelian" class="text-lg text-amber-900 font-bold">Rp 0</span>
            </div>

            <button
              onclick="openCheckout()"
              class="w-full bg-amber-800 hover:bg-amber-900 text-white font-bold py-3 rounded-lg transition shadow flex items-center justify-center gap-2 text-sm"
            >
              <span>Lanjut ke Form Pesan</span>
              <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal Form Checkout / Pemesanan -->
    <div id="modal-checkout" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
      <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden">
        <div class="bg-amber-800 text-white p-4 flex justify-between items-center">
          <h3 class="font-bold text-lg">Form Pemesanan Pembeli</h3>
          <button onclick="closeCheckout()" class="hover:bg-amber-700 p-1 rounded">
            <i data-lucide="x" class="w-5 h-5"></i>
          </button>
        </div>

        <form action="{{ url('/proses-pesan') }}" method="POST" class="p-6 space-y-4">
          @csrf
          <input type="hidden" name="keranjang" id="input-keranjang" value="">
          <input type="hidden" name="total_bayar" id="input-total-bayar" value="0">

          <!-- Ringkasan Total Pesanan -->
          <div class="bg-amber-50 p-3 rounded-lg border border-amber-200 flex justify-between items-center text-sm">
            <span class="text-gray-700 font-medium">Total Pembayaran:</span>
            <span id="checkout-total-display" class="font-bold text-amber-900 text-base">Rp 0</span>
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Pemesan / Nama Toko</label>
            <input
              type="text"
              name="nama_pemesan"
              value="{{ session('nama', '') }}"
              placeholder="Contoh: Toko Kelontong Berkah"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
              required
            />
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Nomor WhatsApp</label>
              <input
                type="tel"
                name="no_wa"
                placeholder="0812xxxx"
                class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
                required
              />
            </div>

            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Metode Pengiriman</label>
              <select name="metode" id="select-metode" onchange="handleMetodePengiriman(this.value)" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                <option value="Armada Sosro (Grosir)">Armada Sosro (Grosir)</option>
                <option value="Ambil Sendiri di Depot">Ambil Sendiri di Depot</option>
              </select>
            </div>
          </div>

          {{-- ===== BAGIAN ALAMAT: Dinamis sesuai metode pengiriman ===== --}}

          {{-- [Armada Sosro] Input Share Location Google Maps --}}
          <div id="section-armada">
            <label class="block text-xs font-semibold text-gray-700 mb-1">
              📍 Bagikan Lokasi Anda <span class="text-gray-400 font-normal">(dari Google Maps)</span>
            </label>
            <p class="text-xs text-gray-500 mb-2">
              Buka Google Maps → Tahan titik lokasi Anda → Klik <strong>Bagikan</strong> → Salin link pendek, lalu tempel di bawah ini.
            </p>
            <input
              type="url"
              id="input-maps-link"
              name="alamat"
              placeholder="https://maps.app.goo.gl/..."
              oninput="previewMapsLink(this.value)"
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
              required
            />
            {{-- Preview maps embed --}}
            <div id="maps-preview-wrapper" class="mt-2 hidden">
              <p class="text-xs text-green-700 font-semibold mb-1">✅ Link lokasi terdeteksi:</p>
              <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                <iframe
                  id="maps-preview-frame"
                  src=""
                  width="100%"
                  height="180"
                  style="border:0;"
                  allowfullscreen=""
                  loading="lazy"
                  referrerpolicy="no-referrer-when-downgrade"
                ></iframe>
              </div>
            </div>
          </div>

          {{-- [Ambil Sendiri] Tampilkan lokasi depot --}}
          <div id="section-depot" class="hidden">
            <input type="hidden" name="alamat" id="hidden-alamat-depot" value="Ambil Sendiri di Depot Sosro - 767J+5G9, Diro, Sendangmulyo, Kec. Minggir, Kabupaten Sleman, DIY 55562">
            <label class="block text-xs font-semibold text-gray-700 mb-1">📍 Lokasi Depot Sosro</label>
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-2">
              <p class="text-xs font-semibold text-amber-900 flex items-start gap-1">
                <span>🏭</span>
                <span>Depot Sosro Minggir</span>
              </p>
              <p class="text-xs text-gray-600 mt-0.5 ml-5">767J+5G9, Diro, Sendangmulyo, Kec. Minggir,<br>Kabupaten Sleman, Daerah Istimewa Yogyakarta 55562</p>
              <a href="https://maps.app.goo.gl/HK6J1PiCe8t5iZis6" target="_blank"
                 class="inline-flex items-center gap-1 mt-1.5 ml-5 text-xs text-blue-600 hover:text-blue-800 underline">
                 🗺️ Buka di Google Maps
              </a>
            </div>
            {{-- Embed Google Maps Depot --}}
            <div class="rounded-lg overflow-hidden border border-gray-200 shadow-sm">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.5938853!2d110.2834!3d-7.7205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a9b9b9b9b9b9b%3A0x0!2sDepot+Sosro+Minggir!5e0!3m2!1sid!2sid!4v1699999999999!5m2!1sid!2sid"
                width="100%"
                height="200"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
            <p class="text-xs text-gray-500 mt-1.5">
              ⏰ Pastikan Anda datang pada jam operasional depot.
            </p>
          </div>

          <div class="pt-4 border-t border-gray-100 flex justify-end space-x-2">
            <button type="button" onclick="closeCheckout()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 font-medium">Batal</button>
            <button type="submit" class="px-5 py-2 bg-amber-800 hover:bg-amber-900 text-white rounded-lg text-sm font-medium shadow-sm">Kirim Pesanan</button>
          </div>
        </form>
      </div>
    </div>

    <!-- MODAL MASUK / DAFTAR AKUN -->
<div id="modal-auth" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
  <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100">
    <div class="bg-amber-800 text-white p-4 flex justify-between items-center">
      <div class="flex space-x-4">
        <button id="tab-login" onclick="switchAuthTab('login')" class="font-bold text-base border-b-2 border-white pb-0.5">Masuk</button>
        <button id="tab-register" onclick="switchAuthTab('register')" class="font-medium text-base text-amber-200 border-b-2 border-transparent hover:text-white pb-0.5">Daftar Akun</button>
        <button id="tab-admin" onclick="switchAuthTab('admin')" class="font-medium text-base text-amber-200 border-b-2 border-transparent hover:text-white pb-0.5">Staff / Admin</button>
      </div>
      <button onclick="closeAuthModal()" class="hover:bg-amber-700 p-1 rounded text-amber-200 hover:text-white">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <div class="p-6">
      <!-- Form Login Pelanggan / Mitra -->
      <form id="form-login" action="{{ url('/proses-login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Email / No. Handphone</label>
          <input type="text" name="email_or_phone" placeholder="Contoh: dimas@gmail.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi (Password)</label>
          <input type="password" name="password" placeholder="••••••••" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
        </div>
        <button type="submit" class="w-full py-2.5 bg-amber-800 hover:bg-amber-900 text-white font-bold rounded-lg transition text-sm shadow">Masuk Sekarang</button>
      </form>

      <!-- Form Register Pelanggan / Mitra -->
      <form id="form-register" action="{{ url('/proses-daftar') }}" method="POST" class="space-y-4 hidden">
        @csrf
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap / Nama Toko</label>
          <input type="text" name="nama_lengkap" placeholder="Contoh: Toko Kelontong Berkah" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
          <input type="email" name="email" placeholder="nama@email.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">No. WhatsApp / HP</label>
          <input type="tel" name="no_hp" placeholder="08123456789" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-700 mb-1">Buat Kata Sandi</label>
          <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
        </div>
        <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg transition text-sm shadow">Daftar Akun Baru</button>
      </form>

      <!-- Form Internal Login (Staff & Admin) -->
      <form id="form-admin" action="{{ url('/proses-admin-login') }}" method="POST" class="space-y-4 hidden">
        @csrf
        <div class="rounded-lg bg-amber-50 border border-amber-200 p-3 text-xs text-amber-900">
          Akses khusus internal (Staff / Admin Distributor) untuk mengelola operasional dan produk.
        </div>
        <div>
          <label for="admin-username" class="block text-xs font-semibold text-gray-700 mb-1">Username Internal</label>
          <input id="admin-username" type="text" name="username" autocomplete="username" placeholder="Masukkan username staff/admin" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
        </div>
        <div>
          <label for="admin-password" class="block text-xs font-semibold text-gray-700 mb-1">Password</label>
          <input id="admin-password" type="password" name="password" autocomplete="current-password" placeholder="Masukkan password" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
        </div>
        <button type="submit" class="w-full py-2.5 bg-gray-900 hover:bg-black text-white font-bold rounded-lg transition text-sm shadow">Masuk Internal</button>
      </form>
    </div>
  </div>
</div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 text-xs py-8 border-t border-gray-800 mt-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-2">
        <p class="text-white font-bold text-sm">PT Sinar Sosro - E-Commerce System</p>
        <p>Sistem Pemesanan Produk Resmi Sosro Indonesia.</p>
      </div>
    </footer>

    <!-- Interactive Script -->
<script>
  lucide.createIcons();

  document.getElementById('product-search')?.addEventListener('input', function () {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.product-card').forEach(card => card.style.display = card.dataset.search.includes(q) ? 'flex' : 'none');
  });
  function filterCatalog(category, button) {
    document.querySelectorAll('.category-btn').forEach(btn => { btn.classList.remove('bg-amber-800','text-white'); btn.classList.add('bg-white','text-gray-700'); });
    button.classList.add('bg-amber-800','text-white');
    document.querySelectorAll('.product-card').forEach(card => card.style.display = category === 'all' || card.dataset.search.includes(category) ? 'flex' : 'none');
  }

  // Array penampung item keranjang belanja
  let keranjang = [];

  function requireLogin() {
    Swal.fire({
      icon: 'info',
      title: 'Perhatian!',
      text: 'Anda harus masuk (login) atau daftar akun terlebih dahulu untuk berbelanja.',
      confirmButtonColor: '#92400e',
      confirmButtonText: 'Masuk / Daftar',
      showCancelButton: true,
      cancelButtonText: 'Batal',
      cancelButtonColor: '#6b7280'
    }).then((result) => {
      if (result.isConfirmed) {
        openAuthModal();
      }
    });
  }

  function toggleCart() {
    const drawer = document.getElementById("cart-drawer");
    drawer.classList.toggle("hidden");
  }

  // Fungsi Tambah Ke Keranjang (Akumulasi Jumlah Produk yang Sama & Cek Stok)
  function addToCart(event, id, nama, harga, btnElement, maxStok) {
    maxStok = parseInt(maxStok) || 0;

    // 1. Cek jika stok awal produk 0
    if (maxStok <= 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Stok Habis',
        text: `Maaf, stok untuk produk "${nama}" sedang tidak tersedia.`,
        confirmButtonColor: '#92400e'
      });
      return;
    }

    // 2. Logika Tambah Data ke Array Keranjang
    let itemDitemukan = keranjang.find(item => item.id === id || item.nama === nama);

    if (itemDitemukan) {
      if (itemDitemukan.jumlah + 1 > maxStok) {
        Swal.fire({
          icon: 'warning',
          title: 'Batas Stok Tercapai',
          text: `Maaf, stok ${nama} yang tersedia hanya tersisa ${maxStok} unit.`,
          confirmButtonColor: '#92400e'
        });
        return;
      }
      itemDitemukan.jumlah += 1;
    } else {
      keranjang.push({
        id: id,
        nama: nama,
        harga: harga,
        jumlah: 1,
        maxStok: maxStok
      });
    }

    renderKeranjang(); // Update data di latar belakang

    // 3. Efek Animasi Produk Melayang ke Ikon Keranjang
    const targetCart = document.getElementById("cart-count") || document.querySelector("[title='Keranjang']");
    
    if (btnElement && targetCart) {
      const card = btnElement.closest('.bg-white') || btnElement.parentElement.parentElement;
      const img = card ? card.querySelector('img') : null;

      const startRect = img ? img.getBoundingClientRect() : btnElement.getBoundingClientRect();
      const targetRect = targetCart.getBoundingClientRect();

      const flyer = document.createElement('img');
      flyer.src = img ? img.src : 'https://via.placeholder.com/50';
      flyer.className = 'fly-item';
      flyer.style.left = `${startRect.left + startRect.width / 2 - 25}px`;
      flyer.style.top = `${startRect.top + startRect.height / 2 - 25}px`;
      
      document.body.appendChild(flyer);

      setTimeout(() => {
        flyer.style.left = `${targetRect.left + targetRect.width / 2 - 25}px`;
        flyer.style.top = `${targetRect.top + targetRect.height / 2 - 25}px`;
        flyer.style.width = '20px';
        flyer.style.height = '20px';
        flyer.style.opacity = '0.5';
      }, 20);

      setTimeout(() => {
        flyer.remove();
        targetCart.classList.add('cart-bounce');
        setTimeout(() => targetCart.classList.remove('cart-bounce'), 400);
      }, 820);
    }
  }

  // Render Ulang Tampilan Keranjang Belanja
  function renderKeranjang() {
    const daftarKeranjang = document.getElementById("daftar-keranjang");
    if (!daftarKeranjang) return;

    let itemHTML = '';

    keranjang.forEach((item, index) => {
      let subtotal = item.harga * item.jumlah;
      let formatHarga = "Rp " + item.harga.toLocaleString("id-ID");
      let formatSubtotal = "Rp " + subtotal.toLocaleString("id-ID");

      itemHTML += `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 produk-di-keranjang mb-2">
          <div>
            <h4 class="font-bold text-sm text-gray-800">${item.nama}</h4>
            <p class="text-xs text-amber-800 font-semibold mt-1">${formatHarga} x ${item.jumlah}</p>
          </div>
          <div class="flex items-center gap-3">
            <span class="font-bold text-gray-900 text-sm">${formatSubtotal}</span>
            <button onclick="hapusDariKeranjang(${index})" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded transition" title="Hapus Barang">
              <i data-lucide="trash-2" class="w-4 h-4"></i>
            </button>
          </div>
        </div>
      `;
    });

    daftarKeranjang.innerHTML = itemHTML || '<p class="text-center text-gray-400 py-6 text-sm">Keranjang belanja kosong</p>';
    lucide.createIcons();
    hitungUlangTotal();
  }

  // Hapus Barang Berdasarkan Index Array
  function hapusDariKeranjang(index) {
    keranjang.splice(index, 1);
    renderKeranjang();
  }

  // Hitung Total Pembelian & Jumlah Barang
  function hitungUlangTotal() {
    let totalBaru = 0;
    let jumlahBarang = 0;

    keranjang.forEach(item => {
      totalBaru += item.harga * item.jumlah;
      jumlahBarang += item.jumlah;
    });

    const elCount = document.getElementById("cart-count");
    const elTotal = document.getElementById("total-pembelian");

    if (elCount) elCount.innerText = jumlahBarang;
    if (elTotal) elTotal.innerText = "Rp " + totalBaru.toLocaleString("id-ID");

    return totalBaru;
  }

  function openCheckout() {
    if (keranjang.length === 0) {
      Swal.fire({
        icon: 'warning',
        title: 'Keranjang Kosong',
        text: 'Silakan tambahkan produk ke keranjang terlebih dahulu!',
        confirmButtonColor: '#92400e'
      });
      return;
    }

    const total = hitungUlangTotal();
    const inputKeranjang = document.getElementById("input-keranjang");
    const inputTotalBayar = document.getElementById("input-total-bayar");
    const displayTotal = document.getElementById("checkout-total-display");

    if (inputKeranjang) inputKeranjang.value = JSON.stringify(keranjang);
    if (inputTotalBayar) inputTotalBayar.value = total;
    if (displayTotal) displayTotal.innerText = "Rp " + total.toLocaleString("id-ID");

    // Reset tampilan metode ke Armada Sosro saat buka checkout
    handleMetodePengiriman('Armada Sosro (Grosir)');
    const selectMetode = document.getElementById('select-metode');
    if (selectMetode) selectMetode.value = 'Armada Sosro (Grosir)';

    toggleCart();
    document.getElementById("modal-checkout").classList.remove("hidden");
  }

  function closeCheckout() {
    document.getElementById("modal-checkout").classList.add("hidden");
  }

  // ===== LOGIKA METODE PENGIRIMAN =====
  function handleMetodePengiriman(metode) {
    const sectionArmada = document.getElementById('section-armada');
    const sectionDepot  = document.getElementById('section-depot');
    const inputMapsLink = document.getElementById('input-maps-link');
    const hiddenAlamat  = document.getElementById('hidden-alamat-depot');

    if (metode === 'Ambil Sendiri di Depot') {
      sectionArmada.classList.add('hidden');
      sectionDepot.classList.remove('hidden');
      // Nonaktifkan required pada input link maps
      if (inputMapsLink) {
        inputMapsLink.removeAttribute('required');
        inputMapsLink.setAttribute('name', '_alamat_armada_disabled');
      }
      if (hiddenAlamat) hiddenAlamat.setAttribute('name', 'alamat');
    } else {
      sectionDepot.classList.add('hidden');
      sectionArmada.classList.remove('hidden');
      // Aktifkan kembali input link maps
      if (inputMapsLink) {
        inputMapsLink.setAttribute('required', 'required');
        inputMapsLink.setAttribute('name', 'alamat');
      }
      if (hiddenAlamat) hiddenAlamat.setAttribute('name', '_alamat_depot_disabled');
    }
  }

  // Preview Google Maps dari link yang dipastekan pengguna
  function previewMapsLink(url) {
    const wrapper = document.getElementById('maps-preview-wrapper');
    const frame   = document.getElementById('maps-preview-frame');

    if (!url || url.trim() === '') {
      wrapper.classList.add('hidden');
      return;
    }

    // Cek apakah URL Google Maps valid
    if (url.includes('maps.app.goo.gl') || url.includes('maps.google.com') || url.includes('goo.gl/maps')) {
      // Buat embed URL dari link Google Maps
      // Untuk link pendek (goo.gl), tampilkan sebagai konfirmasi teks dulu
      // lalu buka preview menggunakan maps embed via place
      const embedUrl = `https://maps.google.com/maps?q=${encodeURIComponent(url)}&output=embed`;
      frame.src = embedUrl;
      wrapper.classList.remove('hidden');
    } else if (url.includes('@') && url.includes('google.com/maps')) {
      // Format: https://www.google.com/maps/place/.../@lat,lng,...
      const embedUrl = url.replace('/maps/place/', '/maps/embed?pb=') || url + '&output=embed';
      frame.src = embedUrl;
      wrapper.classList.remove('hidden');
    } else if (url.length > 10) {
      // Link apapun yang diisi, coba embed
      frame.src = `https://maps.google.com/maps?q=${encodeURIComponent(url)}&output=embed`;
      wrapper.classList.remove('hidden');
    } else {
      wrapper.classList.add('hidden');
    }
  }

  function openAuthModal() {
    document.getElementById("modal-auth").classList.remove("hidden");
  }

  function closeAuthModal() {
    document.getElementById("modal-auth").classList.add("hidden");
  }

  function switchAuthTab(type) {
    ["login", "register", "admin"].forEach((name) => {
      const tab = document.getElementById("tab-" + name);
      const form = document.getElementById("form-" + name);
      const active = name === type;
      tab.className = active
        ? "font-bold text-base border-b-2 border-white pb-0.5"
        : "font-medium text-base text-amber-200 border-b-2 border-transparent hover:text-white pb-0.5";
      form.classList.toggle("hidden", !active);
    });
  }

  window.onload = function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status");
    const nama = urlParams.get("nama");

    if (status === "login_success") {
      Swal.fire({
        icon: "success",
        title: "Login Berhasil!",
        text: "Selamat datang kembali, " + (nama || "Pelanggan") + "!",
        showConfirmButton: false,
        timer: 2500,
        backdrop: `rgba(0,0,0,0.4)`,
      });
    } else if (status === "register_success") {
      Swal.fire({
        icon: "success",
        title: "Pendaftaran Berhasil!",
        text: "Akun Anda telah terdaftar. Silakan masuk.",
        showConfirmButton: false,
        timer: 2500,
        backdrop: `rgba(0,0,0,0.4)`,
      });
    } else if (status === "login_failed") {
      Swal.fire({
        icon: "error",
        title: "Login Gagal!",
        text: "Email/No. HP atau Kata Sandi salah.",
        confirmButtonColor: "#dc2626",
        confirmButtonText: "Coba Lagi",
      }).then(() => {
        openAuthModal();
      });
    } else if (status === "admin_login_failed") {
      Swal.fire({
        icon: "error",
        title: "Login Admin Gagal",
        text: "Username atau password admin salah.",
        confirmButtonColor: "#92400e",
      }).then(() => {
        openAuthModal();
        switchAuthTab("admin");
      });
    } else if (status === "email_exists") {
      Swal.fire({
        icon: "warning",
        title: "Gagal Mendaftar",
        text: "Email sudah terdaftar. Silakan gunakan email lain.",
        confirmButtonColor: "#d97706",
        confirmButtonText: "Kembali",
      }).then(() => {
        openAuthModal();
        switchAuthTab("register");
      });
    } else if (status === "pesan_success") {
      keranjang = [];
      renderKeranjang();
      Swal.fire({
        icon: "success",
        title: "Pesanan Berhasil!",
        text: "Pesanan Anda telah diterima. Staff kami akan segera memproses pesanan.",
        showConfirmButton: false,
        timer: 3000,
        backdrop: `rgba(0,0,0,0.4)`,
      });
    } else if (status === "stok_kurang") {
      Swal.fire({
        icon: "error",
        title: "Stok Tidak Mencukupi",
        text: "Salah satu produk dalam keranjang Anda melebihi stok yang tersedia.",
        confirmButtonColor: "#dc2626",
      });
    } else if (status === "pesan_failed") {
      Swal.fire({
        icon: "error",
        title: "Gagal Memesan",
        text: "Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.",
        confirmButtonColor: "#dc2626",
      });
    }

    if (status) {
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  };
</script>
  </body>
</html>
