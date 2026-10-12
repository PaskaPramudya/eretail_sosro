// Inisialisasi Lucide Icons
lucide.createIcons();

// Fungsi untuk berpindah tab tabel
function switchTab(tableName) {
    const tables = ['produk', 'mitra', 'pesan', 'kirim', 'staff'];
    
    // 1. Sembunyikan semua tabel & atur tombol nav menjadi inactive
    tables.forEach(t => {
        document.getElementById(`table-${t}`).classList.add('hidden');
        
        const navBtn = document.getElementById(`nav-${t}`);
        navBtn.className = 'sidebar-btn sidebar-btn-inactive';
    });

    // 2. Tampilkan tabel aktif
    document.getElementById(`table-${tableName}`).classList.remove('hidden');

    // 3. Aktifkan tombol nav
    const activeNav = document.getElementById(`nav-${tableName}`);
    activeNav.className = 'sidebar-btn sidebar-btn-active';

    // 4. Ubah Judul Tabel
    const titleMap = {
        'produk': { title: 'Tabel Produk', subtitle: 'Kelola katalog produk e-commerce Sosro' },
        'mitra': { title: 'Tabel Mitra', subtitle: 'Daftar mitra bisnis & distributor resmi' },
        'pesan': { title: 'Tabel Pesanan (Pesan)', subtitle: 'Riwayat transaksi pesanan produk' },
        'kirim': { title: 'Tabel Pengiriman (Kirim)', subtitle: 'Status ekspedisi & kurir logistik' },
        'staff': { title: 'Tabel Staff Admin', subtitle: 'Hak akses & kelola anggota pengelola' }
    };

    document.getElementById('table-title').textContent = titleMap[tableName].title;
    document.getElementById('table-subtitle').textContent = titleMap[tableName].subtitle;
}

// Fungsi Modal
function openModal() {
    document.getElementById('modal-form').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal-form').classList.add('hidden');
}