<?php
include 'koneksi.php';
$data_produk = mysqli_query($koneksi, "SELECT * FROM produk");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sosro Official Store</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Top Announcement Bar -->
    <div class="bg-[#0b5326] text-white text-xs py-2 text-center font-medium flex items-center justify-center gap-1">
        <i data-lucide="truck" class="w-3.5 h-3.5"></i>
        <span>Nikmati Keharuman & Kesegaran Teh Asli Indonesia. Bebas Ongkir untuk Pembelian Grosir Mitra</span>
    </div>

    <!-- Header / Navigation Bar -->
    <header class="bg-[#1a1a1a] text-white py-3 px-4 sm:px-8 flex items-center justify-between shadow-md">
        <div class="flex items-center gap-4">
            <div class="bg-[#e30613] text-white font-extrabold px-3 py-1 rounded text-lg flex items-center gap-2">
                <i data-lucide="store" class="w-5 h-5"></i>
                <span>SOSRO</span>
            </div>
            <span class="bg-[#5c2a12] text-xs px-2.5 py-1 rounded-full text-amber-200 font-medium">Official Store</span>
        </div>

        <!-- Search Bar -->
        <div class="hidden md:flex flex-1 max-w-xl mx-8 relative">
            <i data-lucide="search" class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" placeholder="Cari Teh Botol, Fruit Tea, TEBS..." class="w-full pl-9 pr-4 py-1.5 rounded-full text-sm text-gray-800 focus:outline-none">
        </div>

        <!-- User Action Buttons -->
        <div class="flex items-center gap-4">
            <button class="relative bg-amber-900/40 p-2 rounded-full hover:bg-amber-900/70 transition">
                <i data-lucide="shopping-bag" class="w-5 h-5 text-amber-400"></i>
                <span class="absolute -top-1 -right-1 bg-red-600 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold">0</span>
            </button>
            <a href="login.php" class="bg-white/10 border border-white/20 hover:bg-white/20 px-4 py-1.5 rounded-full text-sm font-medium transition">
                Masuk / Daftar
            </a>
        </div>
    </header>

    <!-- HERO BANNER SECTION (Menggunakan Gambar Panorama background.jpg) -->
    <section class="relative w-full min-h-[380px] md:min-h-[440px] bg-cover bg-center bg-no-repeat flex items-center" style="background-image: url('background.jpg');">
        <!-- Overlay transparan tipis agar teks tetap terbaca tajam -->
        <div class="absolute inset-0 bg-black/15"></div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-8 flex flex-col lg:flex-row items-center justify-between">
            
            <!-- Kolom Kiri: Promo, Title, Description, Buttons -->
            <div class="w-full lg:w-[42%] flex flex-col items-start gap-3">
                <span class="bg-[#d32f2f] text-white text-xs font-bold px-3 py-1 rounded shadow uppercase tracking-wide">
                    Promo Mitra & Grosir
                </span>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-white leading-tight drop-shadow-lg">
                    Segarnya Minuman Asli Sosro<br>Langsung Dari Pabrik!
                </h1>
                <p class="text-white text-sm md:text-base drop-shadow max-w-md leading-relaxed">
                    Pesan beragam produk Teh Botol Sosro, Fruit Tea, TEBS, dan Prima langsung untuk kebutuhan toko, cafe, maupun konsumsi harian Anda.
                </p>
                <div class="flex flex-wrap gap-3 mt-2">
                    <a href="#katalog" class="bg-white text-[#d32f2f] font-bold px-6 py-2.5 rounded-lg shadow hover:bg-gray-100 transition">
                        Lihat Katalog
                    </a>
                    <a href="#panduan" class="bg-[#5c2a12]/70 border border-white/40 text-white font-bold px-6 py-2.5 rounded-lg shadow backdrop-blur-sm hover:bg-[#5c2a12]/90 transition">
                        Panduan Mitra
                    </a>
                </div>
            </div>

            <!-- Area Tengah: Ruang Kosong agar Logo Tehbotol Sosro di tengah background.jpg tidak tertutup -->
            <div class="hidden lg:block w-[32%]"></div>

            <!-- Kolom Kanan: Card 100% Produk Original -->
            <div class="hidden md:flex w-full lg:w-[26%] justify-end mt-6 lg:mt-0">
                <div class="bg-gradient-to-b from-[#5c2a12]/85 to-[#3a1a0b]/90 border border-[#8b4513]/60 p-6 rounded-2xl shadow-xl flex flex-col items-center text-center backdrop-blur-md w-60">
                    <i data-lucide="shield-check" class="w-12 h-12 text-yellow-500 mb-2"></i>
                    <h3 class="text-white font-bold text-base mb-1">100% Produk Original</h3>
                    <p class="text-gray-300 text-xs">Jaminan Kualitas & Kedaluwarsa Panjang</p>
                </div>
            </div>

        </div>
    </section>

    <!-- KATALOG PRODUK SECTION -->
    <section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Section Title & Filter Buttons -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Katalog Produk</h2>
                <p class="text-sm text-gray-500">Pilih ragam produk kesegaran Sosro favorit Anda</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button class="bg-[#5c2a12] text-white text-xs font-semibold px-4 py-2 rounded-full">Semua Produk</button>
                <button class="bg-white border border-gray-300 text-gray-700 text-xs font-semibold px-4 py-2 rounded-full hover:bg-gray-50">Teh Botol Sosro</button>
                <button class="bg-white border border-gray-300 text-gray-700 text-xs font-semibold px-4 py-2 rounded-full hover:bg-gray-50">Fruit Tea</button>
                <button class="bg-white border border-gray-300 text-gray-700 text-xs font-semibold px-4 py-2 rounded-full hover:bg-gray-50">TEBS Sparkling</button>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            if(isset($data_produk) && mysqli_num_rows($data_produk) > 0) {
                while($row = mysqli_fetch_assoc($data_produk)) {
            ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between hover:shadow-md transition">
                    <div class="p-4 relative">
                        <span class="absolute top-3 left-3 bg-[#5c2a12] text-white text-[10px] font-bold px-2 py-0.5 rounded">Stok <?= $row['stok'] ?></span>
                        <div class="w-full h-48 flex items-center justify-center my-2">
                            <img src="<?= $row['gambar'] ?? 'teh botol 220ml.jpg' ?>" alt="<?= $row['nama_produk'] ?>" class="max-h-full object-contain">
                        </div>
                        <span class="text-[10px] font-bold uppercase text-gray-400 tracking-wider">Teh Botol Sosro</span>
                        <h3 class="font-bold text-gray-800 text-sm mt-1"><?= $row['nama_produk'] ?></h3>
                    </div>
                    <div class="px-4 pb-4 pt-2 flex items-center justify-between border-t border-gray-100">
                        <div>
                            <span class="text-[10px] text-gray-400 block">Harga Satuan</span>
                            <span class="text-sm font-bold text-gray-900">Rp <?= number_format($row['harga'], 0, ',', '.') ?></span>
                        </div>
                        <button class="bg-[#5c2a12] text-white p-2 rounded-lg hover:bg-amber-900 transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            <?php 
                }
            } else {
            ?>
                <!-- Fallback jika database belum berisi data -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between">
                    <div class="p-4 relative">
                        <span class="absolute top-3 left-3 bg-[#5c2a12] text-white text-[10px] font-bold px-2 py-0.5 rounded">Stok 170</span>
                        <div class="w-full h-48 flex items-center justify-center my-2">
                            <img src="teh botol 220ml.jpg" alt="Teh Botol Sosro RGB 220 ml" class="max-h-full object-contain">
                        </div>
                        <span class="text-[10px] font-bold uppercase text-gray-400 tracking-wider">Teh Botol Sosro</span>
                        <h3 class="font-bold text-gray-800 text-sm mt-1">Teh Botol Sosro RGB 220 ml</h3>
                    </div>
                    <div class="px-4 pb-4 pt-2 flex items-center justify-between border-t border-gray-100">
                        <div>
                            <span class="text-[10px] text-gray-400 block">Harga Satuan</span>
                            <span class="text-sm font-bold text-gray-900">Rp 4.000</span>
                        </div>
                        <button class="bg-[#5c2a12] text-white p-2 rounded-lg hover:bg-amber-900 transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between">
                    <div class="p-4 relative">
                        <span class="absolute top-3 left-3 bg-[#5c2a12] text-white text-[10px] font-bold px-2 py-0.5 rounded">Stok 85</span>
                        <div class="w-full h-48 flex items-center justify-center my-2">
                            <img src="Fruit Tea Apel 350ml.jpg" alt="Fruit Tea Apel 350ml" class="max-h-full object-contain">
                        </div>
                        <span class="text-[10px] font-bold uppercase text-gray-400 tracking-wider">Fruit Tea</span>
                        <h3 class="font-bold text-gray-800 text-sm mt-1">Fruit Tea Apel 350ml</h3>
                    </div>
                    <div class="px-4 pb-4 pt-2 flex items-center justify-between border-t border-gray-100">
                        <div>
                            <span class="text-[10px] text-gray-400 block">Harga Satuan</span>
                            <span class="text-sm font-bold text-gray-900">Rp 6.000</span>
                        </div>
                        <button class="bg-[#5c2a12] text-white p-2 rounded-lg hover:bg-amber-900 transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between">
                    <div class="p-4 relative">
                        <span class="absolute top-3 left-3 bg-[#5c2a12] text-white text-[10px] font-bold px-2 py-0.5 rounded">Stok 45</span>
                        <div class="w-full h-48 flex items-center justify-center my-2">
                            <img src="TEBS Sparkling 500ml.jpg" alt="TEBS Sparkling 500ml" class="max-h-full object-contain">
                        </div>
                        <span class="text-[10px] font-bold uppercase text-gray-400 tracking-wider">TEBS Sparkling</span>
                        <h3 class="font-bold text-gray-800 text-sm mt-1">TEBS Sparkling 500ml</h3>
                    </div>
                    <div class="px-4 pb-4 pt-2 flex items-center justify-between border-t border-gray-100">
                        <div>
                            <span class="text-[10px] text-gray-400 block">Harga Satuan</span>
                            <span class="text-sm font-bold text-gray-900">Rp 7.500</span>
                        </div>
                        <button class="bg-[#5c2a12] text-white p-2 rounded-lg hover:bg-amber-900 transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col justify-between">
                    <div class="p-4 relative">
                        <span class="absolute top-3 left-3 bg-[#5c2a12] text-white text-[10px] font-bold px-2 py-0.5 rounded">Stok 40</span>
                        <div class="w-full h-48 flex items-center justify-center my-2">
                            <img src="Teh Botol Kotak 250ml (Dus).jpg" alt="Teh Botol Kotak 250ml (Dus)" class="max-h-full object-contain">
                        </div>
                        <span class="text-[10px] font-bold uppercase text-gray-400 tracking-wider">Teh Botol Sosro</span>
                        <h3 class="font-bold text-gray-800 text-sm mt-1">Teh Botol Kotak 250ml (Dus)</h3>
                    </div>
                    <div class="px-4 pb-4 pt-2 flex items-center justify-between border-t border-gray-100">
                        <div>
                            <span class="text-[10px] text-gray-400 block">Harga Satuan</span>
                            <span class="text-sm font-bold text-gray-900">Rp 78.000</span>
                        </div>
                        <button class="bg-[#5c2a12] text-white p-2 rounded-lg hover:bg-amber-900 transition">
                            <i data-lucide="plus" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>