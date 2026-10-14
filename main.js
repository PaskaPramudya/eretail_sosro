        // Render Icons pertama kali
        lucide.createIcons();

        // Variabel untuk menyimpan data keranjang
        let dataKeranjang = {};

        // Buka/Tutup Keranjang
        function toggleCart() {
            document.getElementById('cart-drawer').classList.toggle('hidden');
        }

        // Fungsi Tambah Barang ke Keranjang
        function addToCart(nama, harga) {
            // Jika barang sudah ada, tambah qty. Jika belum, buat baru.
            if (dataKeranjang[nama]) {
                dataKeranjang[nama].qty += 1;
            } else {
                dataKeranjang[nama] = { harga: harga, qty: 1 };
            }
            
            renderKeranjang();
            document.getElementById('cart-drawer').classList.remove('hidden');
        }

        // Fungsi Tambah/Kurang Qty dari dalam keranjang
        function updateQty(nama, jumlah) {
            if (dataKeranjang[nama]) {
                dataKeranjang[nama].qty += jumlah;
                // Jika qty menjadi 0 atau kurang, hapus barang dari keranjang
                if (dataKeranjang[nama].qty <= 0) {
                    delete dataKeranjang[nama];
                }
                renderKeranjang();
            }
        }

        // Fungsi Hapus Total 1 Baris Barang
        function hapusDariKeranjang(nama) {
            delete dataKeranjang[nama];
            renderKeranjang();
        }

        // Fungsi merender ulang tampilan HTML keranjang
        function renderKeranjang() {
            const wadah = document.getElementById('daftar-keranjang');
            const keys = Object.keys(dataKeranjang);
            let html = '';
            let totalHarga = 0;
            let totalBarang = 0;

            if (keys.length === 0) {
                // Tampilan jika keranjang kosong
                html = `
                    <div id="empty-cart-msg" class="text-center text-slate-400 py-10 flex flex-col items-center justify-center h-full">
                        <i data-lucide="shopping-bag" class="w-12 h-12 mb-3 opacity-20"></i>
                        <p class="text-sm">Keranjang Anda masih kosong</p>
                    </div>
                `;
            } else {
                // Loop semua barang yang ada di keranjang
                keys.forEach(nama => {
                    const item = dataKeranjang[nama];
                    const subtotal = item.harga * item.qty;
                    totalHarga += subtotal;
                    totalBarang += item.qty;

                    const formatHargaSatuan = 'Rp ' + item.harga.toLocaleString('id-ID');
                    const formatSubtotal = 'Rp ' + subtotal.toLocaleString('id-ID');

                    html += `
                        <div class="flex items-center justify-between p-4 bg-white rounded-xl border border-slate-100 shadow-sm transition-all hover:border-brand-200">
                            <div class="flex-1">
                                <h4 class="font-bold text-sm text-slate-900 line-clamp-1">${nama}</h4>
                                <div class="flex items-center gap-4 mt-3">
                                    
                                    <!-- Kontrol Tambah/Kurang Kuantitas -->
                                    <div class="flex items-center bg-slate-50 border border-slate-200 rounded-lg">
                                        <button onclick="updateQty('${nama}', -1)" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:bg-slate-200 hover:text-brand-600 transition rounded-l-lg font-bold">-</button>
                                        <span class="w-8 text-center text-xs font-bold text-slate-900">${item.qty}</span>
                                        <button onclick="updateQty('${nama}', 1)" class="w-8 h-8 flex items-center justify-center text-slate-500 hover:bg-slate-200 hover:text-brand-600 transition rounded-r-lg font-bold">+</button>
                                    </div>
                                    
                                    <span class="text-xs font-semibold text-slate-400">${formatHargaSatuan} / item</span>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-3 ml-4">
                                <span class="font-extrabold text-slate-900 text-sm">${formatSubtotal}</span>
                                <button onclick="hapusDariKeranjang('${nama}')" class="text-slate-300 hover:text-red-500 p-1 rounded-lg transition-colors" title="Hapus Produk">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
            }

            // Memasukkan HTML ke dalam wadah keranjang
            wadah.innerHTML = html;

            // Render ulang ikon Lucide untuk elemen yang baru saja dibuat
            lucide.createIcons();

            // Memperbarui Total Harga di bawah
            document.getElementById('total-pembelian').innerText = 'Rp ' + totalHarga.toLocaleString('id-ID');

            // Memperbarui Animasi Angka/Badge Keranjang di header
            const badge = document.getElementById('cart-count');
            badge.innerText = totalBarang;
            badge.classList.add('scale-125');
            setTimeout(() => badge.classList.remove('scale-125'), 200);
        }

        // LOGIKA MODAL
        function openCheckout() {
            const count = document.getElementById('cart-count').innerText;
            if(count === "0") {
                Swal.fire({icon: 'info', title: 'Keranjang Kosong', text: 'Silakan pilih produk terlebih dahulu.', confirmButtonColor: '#0f172a'});
                return;
            }
            toggleCart();
            document.getElementById('modal-checkout').classList.remove('hidden');
        }
        function closeCheckout() { document.getElementById('modal-checkout').classList.add('hidden'); }
        function openAuthModal() { document.getElementById('modal-auth').classList.remove('hidden'); }
        function closeAuthModal() { document.getElementById('modal-auth').classList.add('hidden'); }

        // LOGIKA TABS AUTENTIKASI
        function switchAuthTab(type) {
            ['login', 'register', 'admin'].forEach(name => {
                const isMatch = name === type;
                const tab = document.getElementById('tab-' + name);
                
                if(isMatch) {
                    tab.className = "flex-1 py-2 text-sm font-bold bg-white text-slate-900 rounded-lg shadow-sm transition-all";
                } else {
                    tab.className = "flex-1 py-2 text-sm font-semibold text-slate-500 hover:text-slate-900 hover:bg-slate-200/50 rounded-lg transition-all";
                }
                
                document.getElementById('form-' + name).classList.toggle('hidden', !isMatch);
            });
        }

        // PENANGANAN STATUS BACKEND DARI URL
        window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            const status = params.get('status');
            
            if (status) {
                const notif = {
                    'login_success': {i: 'success', t: 'Login Berhasil!', c: false},
                    'register_success': {i: 'success', t: 'Pendaftaran Berhasil!', text: 'Silakan login.', c: false},
                    'login_failed': {i: 'error', t: 'Login Gagal!', text: 'Email/No HP atau sandi salah.', c: true, cb: () => openAuthModal()},
                    'admin_login_failed': {i: 'error', t: 'Akses Ditolak', text: 'Kredensial Admin tidak valid.', c: true, cb: () => { openAuthModal(); switchAuthTab('admin'); }},
                    'email_exists': {i: 'warning', t: 'Email Terdaftar', text: 'Gunakan email lain.', c: true, cb: () => { openAuthModal(); switchAuthTab('register'); }}
                }[status];

                if (notif) {
                    Swal.fire({
                        icon: notif.i, 
                        title: notif.t, 
                        text: notif.text || '', 
                        showConfirmButton: notif.c, 
                        confirmButtonColor: '#0f172a',
                        timer: notif.c ? undefined : 2000,
                        customClass: { popup: 'rounded-2xl' }
                    }).then(() => { if(notif.cb) notif.cb(); });
                }
                // Bersihkan URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        };
