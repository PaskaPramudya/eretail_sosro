<?php
session_start();
include 'koneksi.php';

// Ambil data produk dari database
$query_produk = mysqli_query($koneksi, "SELECT * FROM produk");
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>E-Commerce Sosro - Toko Online Resmi</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- SweetAlert2 CDN untuk Animasi Centang Hijau & Silang Merah -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
              placeholder="Cari Teh Botol, Fruit Tea, TEBS..."
              class="w-full pl-9 pr-4 py-2 bg-white text-gray-800 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-inner"
            />
          </div>
        </div>

        <!-- User Actions & Cart -->
        <div class="flex items-center space-x-4">
          <button
            onclick="toggleCart()"
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
          <?php if (isset($_SESSION['nama'])): ?>
            <div class="flex items-center gap-2">
              <span class="text-sm font-semibold bg-amber-900/60 px-3 py-1.5 rounded-lg border border-amber-600/50 flex items-center gap-2 text-amber-100">
                <i data-lucide="user" class="w-4 h-4 text-amber-300"></i>
                <?php echo htmlspecialchars($_SESSION['nama']); ?>
              </span>
              <a href="logout.php" class="text-xs font-semibold bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition shadow-sm">
                Keluar
              </a>
            </div>
          <?php else: ?>
            <button
              onclick="openAuthModal()"
              class="text-sm font-medium hover:text-amber-200 transition hidden sm:block cursor-pointer bg-amber-900/40 hover:bg-amber-900 px-3 py-1.5 rounded-lg border border-amber-600/50"
            >
              Masuk / Daftar
            </button>
          <?php endif; ?>
        </div>
      </div>
    </header>

    <!-- Hero Banner -->
    <section class="bg-gradient-to-r from-amber-800 via-amber-700 to-red-700 text-white py-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="space-y-4 text-center md:text-left max-w-xl">
          <span class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Promo Mitra & Grosir</span>
          <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">
            Segarnya Minuman Asli Sosro Langsung Dari Pabrik!
          </h1>
          <p class="text-amber-100 text-sm sm:text-base">
            Pesan beragam produk Teh Botol Sosro, Fruit Tea, TEBS, dan Prima langsung untuk kebutuhan toko, cafe, maupun konsumsi harian Anda.
          </p>
          <div class="pt-2 flex flex-wrap justify-center md:justify-start gap-3">
            <a href="#katalog" class="bg-white text-amber-900 hover:bg-amber-100 font-bold px-6 py-3 rounded-lg shadow transition text-sm">Lihat Katalog</a>
            <a href="#cara-pesan" class="bg-amber-900/50 hover:bg-amber-900 border border-amber-500 font-medium px-5 py-3 rounded-lg transition text-sm">Panduan Mitra</a>
          </div>
        </div>

        <div class="w-full md:w-auto flex justify-center">
          <div class="bg-white/10 backdrop-blur-md p-6 rounded-2xl border border-white/20 text-center space-y-2">
            <i data-lucide="shield-check" class="w-12 h-12 text-amber-300 mx-auto"></i>
            <p class="font-bold text-lg">100% Produk Original</p>
            <p class="text-xs text-amber-100">Jaminan Kualitas & Kadaluarsa Panjang</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <main id="katalog" class="max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1">
      <!-- Filter Category Tabs -->
      <div class="flex flex-wrap items-center justify-between gap-4 mb-8 border-b border-gray-200 pb-4">
        <div>
          <h2 class="text-2xl font-bold text-gray-900">Katalog Produk</h2>
          <p class="text-xs text-gray-500">Pilih ragam produk kesegaran Sosro favorit Anda</p>
        </div>

        <div class="flex flex-wrap gap-2">
          <button class="px-4 py-2 rounded-full text-xs font-semibold bg-amber-800 text-white shadow-sm">Semua Produk</button>
          <button class="px-4 py-2 rounded-full text-xs font-semibold bg-white border border-gray-300 text-gray-700 hover:bg-amber-50 transition">Teh Botol Sosro</button>
          <button class="px-4 py-2 rounded-full text-xs font-semibold bg-white border border-gray-300 text-gray-700 hover:bg-amber-50 transition">Fruit Tea</button>
          <button class="px-4 py-2 rounded-full text-xs font-semibold bg-white border border-gray-300 text-gray-700 hover:bg-amber-50 transition">TEBS Sparkling</button>
        </div>
      </div>

      <!-- Product Grid Dinamis dari Database -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php while ($row = mysqli_fetch_assoc($query_produk)) : ?>
          <?php 
            // Cek nama file gambar dari database, jika kosong gunakan default
            $file_gambar = !empty($row['gambar']) ? $row['gambar'] : 'Fruit Tea Apel 350ml.jpg'; 
            $stok_tersedia = isset($row['stok']) ? $row['stok'] : 0;
          ?>
          <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition flex flex-col group">
            <div class="bg-gray-100 h-48 flex items-center justify-center p-4 relative overflow-hidden">
              <?php if (strtolower($row['kategori']) == 'minuman' && $row['id'] == 1): ?>
                <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded z-10">Terlaris</span>
              <?php elseif (strpos(strtolower($row['nama_produk']), 'tebs') !== false): ?>
                <span class="absolute top-3 left-3 bg-amber-600 text-white text-[10px] font-bold px-2 py-0.5 rounded z-10">Sparkling</span>
              <?php endif; ?>

              <img
                src="<?= htmlspecialchars($file_gambar); ?>"
                alt="<?= htmlspecialchars($row['nama_produk']); ?>"
                class="w-full h-full object-contain group-hover:scale-110 transition transform duration-300"
              />
            </div>

            <div class="p-4 flex-1 flex flex-col justify-between space-y-3">
              <div>
                <span class="text-[11px] font-medium text-amber-800 uppercase tracking-wider">
                  <?= htmlspecialchars($row['kategori']); ?>
                </span>

                <h3 class="font-bold text-gray-900 text-base leading-snug">
                  <?= htmlspecialchars($row['nama_produk']); ?>
                </h3>

                <p class="text-xs text-emerald-600 font-semibold mt-1">
                  Stok Tersedia: <?= $stok_tersedia; ?>
                </p>
              </div>

              <div class="pt-2 border-t border-gray-100 flex items-center justify-between">
                <div>
                  <p class="text-xs text-gray-400">Harga Satuan</p>
                  <p class="text-lg font-bold text-amber-900">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p>
                </div>

                <button
                  onclick="addToCart('<?= htmlspecialchars(addslashes($row['nama_produk'])); ?>', <?= $row['harga']; ?>)"
                  class="bg-amber-800 hover:bg-amber-900 text-white p-2.5 rounded-lg transition shadow-sm"
                >
                  <i data-lucide="plus" class="w-5 h-5"></i>
                </button>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
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

        <form action="proses_pesan.php" method="POST" class="p-6 space-y-4">
          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Nama Pemesan / Nama Toko</label>
            <input
              type="text"
              name="nama_pemesan"
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
              <select name="metode" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                <option value="Armada Sosro (Grosir)">Armada Sosro (Grosir)</option>
                <option value="Ambil Sendiri di Depot">Ambil Sendiri di Depot</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-semibold text-gray-700 mb-1">Alamat Lengkap Pengiriman</label>
            <textarea
              name="alamat"
              rows="3"
              placeholder="Masukkan jalan, RT/RW, dan kecamatan..."
              class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500"
              required
            ></textarea>
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
            <button id="tab-admin" onclick="switchAuthTab('admin')" class="font-medium text-base text-amber-200 border-b-2 border-transparent hover:text-white pb-0.5">Admin</button>
          </div>
          <button onclick="closeAuthModal()" class="hover:bg-amber-700 p-1 rounded text-amber-200 hover:text-white">
            <i data-lucide="x" class="w-5 h-5"></i>
          </button>
        </div>

        <div class="p-6">
          <!-- Form Login -->
          <form id="form-login" action="proses_login.php" method="POST" class="space-y-4">
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Email / No. Handphone</label>
              <input type="text" name="email_or_phone" placeholder="Contoh: ahmad@gmail.com" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
            </div>
            <div>
              <label class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi (Password)</label>
              <input type="password" name="password" placeholder="••••••••" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
            </div>
            <button type="submit" class="w-full py-2.5 bg-amber-800 hover:bg-amber-900 text-white font-bold rounded-lg transition text-sm shadow">Masuk Sekarang</button>
          </form>

          <!-- Form Register -->
          <form id="form-register" action="proses_daftar.php" method="POST" class="space-y-4 hidden">
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

          <!-- Form Admin -->
          <form id="form-admin" action="proses_admin_login.php" method="POST" class="space-y-4 hidden">
            <div class="rounded-lg bg-amber-50 border border-amber-200 p-3 text-xs text-amber-900">
              Login khusus administrator untuk mengelola produk dan kategori.
            </div>
            <div>
              <label for="admin-username" class="block text-xs font-semibold text-gray-700 mb-1">Username Admin</label>
              <input id="admin-username" type="text" name="username" autocomplete="username" placeholder="Masukkan username admin" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
            </div>
            <div>
              <label for="admin-password" class="block text-xs font-semibold text-gray-700 mb-1">Password Admin</label>
              <input id="admin-password" type="password" name="password" autocomplete="current-password" placeholder="Masukkan password admin" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500" required />
            </div>
            <button type="submit" class="w-full py-2.5 bg-gray-900 hover:bg-black text-white font-bold rounded-lg transition text-sm shadow">Masuk sebagai Admin</button>
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

    <!-- Interactive Script Terpadu -->
    <script>
      lucide.createIcons();

      // Fungsi Buka/Tutup Keranjang
      function toggleCart() {
        const drawer = document.getElementById("cart-drawer");
        drawer.classList.toggle("hidden");
      }

      // Fungsi Menambahkan Barang ke Keranjang
      function addToCart(nama, harga) {
        const daftarKeranjang = document.getElementById("daftar-keranjang");
        const formatRupiah = "Rp " + harga.toLocaleString("id-ID");

        const itemHTML = `
          <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200 produk-di-keranjang">
            <div>
              <h4 class="font-bold text-sm text-gray-800">${nama}</h4>
              <p class="text-xs text-amber-800 font-semibold mt-1">${formatRupiah} x 1</p>
            </div>
            <div class="flex items-center gap-3">
              <span class="font-bold text-gray-900 text-sm harga-item" data-harga="${harga}">${formatRupiah}</span>
              <button onclick="hapusDariKeranjang(this)" class="text-gray-400 hover:text-red-600 hover:bg-red-50 p-1.5 rounded transition" title="Hapus Barang">
                <i data-lucide="trash-2" class="w-4 h-4"></i>
              </button>
            </div>
          </div>
        `;

        daftarKeranjang.insertAdjacentHTML("beforeend", itemHTML);
        lucide.createIcons();
        hitungUlangTotal();

        const cartDrawer = document.getElementById("cart-drawer");
        cartDrawer.classList.remove("hidden");
      }

      // Fungsi Menghapus Barang
      function hapusDariKeranjang(tombol) {
        const barisProduk = tombol.closest(".produk-di-keranjang");
        if (barisProduk) {
          barisProduk.remove();
        }
        hitungUlangTotal();
      }

      // Fungsi Hitung Total Harga & Update Angka Keranjang
      function hitungUlangTotal() {
        const semuaHarga = document.querySelectorAll(".harga-item");
        let totalBaru = 0;
        let jumlahBarang = 0;

        semuaHarga.forEach(function (elemen) {
          const harga = parseInt(elemen.getAttribute("data-harga")) || 0;
          totalBaru += harga;
          jumlahBarang++;
        });

        document.getElementById("cart-count").innerText = jumlahBarang;
        const formatRupiah = "Rp " + totalBaru.toLocaleString("id-ID");
        document.getElementById("total-pembelian").innerText = formatRupiah;
      }

      // Fungsi Buka/Tutup Form Checkout
      function openCheckout() {
        toggleCart();
        document.getElementById("modal-checkout").classList.remove("hidden");
      }

      function closeCheckout() {
        document.getElementById("modal-checkout").classList.add("hidden");
      }

      // FUNGSI UNTUK MODAL LOGIN & DAFTAR
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

      // PENANGANAN NOTIFIKASI ANIMASI CENTANG HIJAU & SILANG MERAH (SweetAlert2)
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
        }

        if (status) {
          window.history.replaceState({}, document.title, window.location.pathname);
        }
      };
    </script>
  </body>
</html>