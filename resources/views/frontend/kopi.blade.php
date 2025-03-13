<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cafe KuyBrew - Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-image: url('https://png.pngtree.com/thumb_back/fw800/background/20231024/pngtree-aesthetic-blend-roasted-coffee-beans-atop-a-weathered-concrete-surface-image_13690854.png');
            background-size: 100% 100vh; 
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0; 
            height: 100vh; 
        }

        .loading-screen {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .loading-logo {
            width: 100px;
            animation: spin 6s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        /* Modal Styles */
        #cartModal {
            display: none;
            opacity: 0;
            visibility: hidden;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            transition: opacity 0.5s ease, visibility 0s 0.5s;
        }

        #cartModal.show {
            display: flex;
            opacity: 1;
            visibility: visible;
            transition: opacity 0.5s ease, visibility 0s 0s;
        }

        #cartModal .modal-content {
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative; /* Added for positioning the close button */
        }

        .text-shadow-lg {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
            color: #000; /* Color of the close button */
        }

        #notification {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .opacity-100 {
            opacity: 1 !important;
        }
    </style>
</head>

<body class="bg-[#FFF8DC] font-[Poppins] text-[#2c1810] min-h-screen flex flex-col">
    <div id="loadingScreen" class="loading-screen">
        <img src="{{ asset('storage/logo.png') }}" alt="Loading..." class="loading-logo">
        <p>Loading...</p>
    </div>
    
    <body class="font-[Poppins] text-[#2c1810]">
    <header class="from-[#4b2c01] to-[#8B4513] text-white py-8 text-center mb-12">
    <h1 class="font-[Playfair Display] text-5xl text-shadow-lg mb-4">
        <i class="fas fa-coffee mr-2"></i>Cafe KuyBrew
    </h1>
    <div class="flex items-center justify-between bg-gradient-to-br from-[#4b2c01]/50 to-[#8B4513]/50 py-8 shadow-md">
        <!-- Bagian Kiri (Kosong atau Tambahan Ikon) -->
        <div class="flex items-center w-1/4"></div>

        <!-- Bagian Tengah (Menu Utama) -->
        <div class="flex-grow text-center">
            <ul class="flex space-x-8 justify-center">
                <li>
                    <a href="{{ route('frontend.menu') }}" class="hover:text-[var(--accent-color)] transition">
                        {{ __('Menu') }}
                    </a>
                </li>
                <li class="relative group">
    <button onclick="toggleDropdown('dropdownCategoryMenu')" class="hover:text-[var(--accent-color)] transition flex items-center px-4">
        <span>{{ __('Kategori') }}</span>
        <i id="dropdownIconCategory" class="fas fa-chevron-down ml-2 transition-transform duration-200"></i>
    </button>
    <!-- Dropdown Category -->
    <ul id="dropdownCategoryMenu" class="absolute left-0 mt-2 hidden bg-white text-black shadow-lg rounded-md w-56 z-10">
        <!-- Dropdown Makanan -->
        <li class="relative group">
            <button onclick="toggleSubmenu('dropdownMakananMenu')" class="block w-full text-left px-4 py-2 flex items-center hover:bg-gray-100">
                <i class="fas fa-utensils mr-2 text-gray-700"></i> {{ __('Makanan') }}
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
            </button>
            <ul id="dropdownMakananMenu" class="absolute left-full top-0 hidden bg-white text-black shadow-lg rounded-md w-48 z-10">
                <li class="hover:bg-gray-200 transition">
                <a href="{{ route('frontend.makanan') }}" class="block px-4 py-2">
                    <i class="fas fa-utensils mr-2"></i>Makanan Berat
                </a>
                </li>
                <li class="hover:bg-gray-200 transition">
                <a href="{{ route('frontend.cemilan') }}" class="block px-4 py-2">
                    <i class="fas fa-pizza-slice mr-2"></i>Cemilan Ringan
                </a>
                </li>
                <li class="hover:bg-gray-200 transition">
                    <a href="{{ route('frontend.dessert') }}" class="block px-4 py-2">
                        <i class="fas fa-cake mr-2"></i>Dessert
                    </a>
                </li>
            </ul>
        </li>
        <!-- Dropdown Minuman -->
        <li class="relative group">
            <button onclick="toggleSubmenu('dropdownMinumanMenu')" class="block w-full text-left px-4 py-2 flex items-center hover:bg-gray-100">
                <i class="fas fa-coffee mr-2 text-gray-700"></i> {{ __('Minuman') }}
                <i class="fas fa-chevron-right ml-auto text-gray-500"></i>
            </button>
            <ul id="dropdownMinumanMenu" class="absolute left-full top-0 hidden bg-white text-black shadow-lg rounded-md w-60 z-10">
            <li class="hover:bg-gray-200 transition">
                <a href="{{ route('frontend.kopi') }}" class="block px-4 py-2 flex items-center">
                    <i class="fas fa-coffee mr-2"></i> Kopi
                </a>
            </li>
            <li class="hover:bg-gray-200 transition">
                <a href="{{ route('frontend.nonkopi') }}" class="block px-4 py-2 flex items-center">
                    <i class="fas fa-mug-hot mr-2"></i> Non-Kopi
                </a>
            </li>
            <li class="hover:bg-gray-200 transition">
                <a href="{{ route('frontend.minuman') }}" class="block px-4 py-2 flex items-center">
                    <i class="fas fa-glass-whiskey mr-2"></i> Minuman Dingin
                </a>
            </li>
            </ul>
            </li>
                <li class="hover:bg-gray-200 transition">
                    <a href="{{ route('frontend.paket') }}" class="block px-4 py-2 flex items-center">
                        <i class="fas fa-star mr-2 text-gray-700"></i> {{ __('Paket Spesial') }}
                    </a>
                </li>
            </ul>
            </li>
                <li>
                    <a href="{{ route('frontend.about') }}" class="hover:text-[var(--accent-color)] transition">
                        {{ __('Tentang Kami') }}
                    </a>
                </li>
                <li>
                    <a href="{{ route('frontend.store') }}" class="hover:text-[var(--accent-color)] transition">
                        {{ __('Toko') }}
                    </a>
                </li>
            </ul>
        </div>

        <!-- Bagian Kanan (Username atau Login/Register) -->
        <ul class="flex space-x-4 pr-4 text-right w-1/4 justify-end">
            @guest
                @if (Route::has('login'))
                    <li>
                        <a href="{{ route('login') }}" class="text-white-700 hover:text-[var(--accent-color)] transition">
                            {{ __('Login') }}
                        </a>
                    </li>
                @endif
                @if (Route::has('register'))
                    <li>
                        <a href="{{ route('register') }}" class="text-white-700 hover:text-[var(--accent-color)] transition">
                            {{ __('Register') }}
                        </a>
                    </li>
                @endif
            @else
                <li class="relative">
                    <button class="text-white-700 hover:text-[var(--accent-color)] transition dropdown-toggle"
                        onclick="toggleDropdown('dropdownUserMenu')">
                        <i class="fas fa-user-circle mr-1"></i>
                        <span class="">{{ Auth::user()->name }}</span>
                    </button>
                    <!-- Dropdown User -->
                    <div id="dropdownUserMenu"
                        class="absolute right-0 hidden bg-white text-black shadow-lg mt-2 rounded-md z-10">
                        <a class="block px-4 py-2 text-sm" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</header>

<div class="container mx-auto px-4 flex-grow">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        @foreach ($menus as $menu)
        @if ($menu->categories->nama === 'Kopi')
            <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all hover:translate-y-[-10px] hover:shadow-2xl">
                <img src="{{ asset('/storage/menus/' . $menu->image) }}" class="w-full h-64 object-cover transition-all hover:scale-105" alt="{{ $menu->nama }}">
                <div class="p-6">
                    <h2 class="text-[#4b2c01] font-[Playfair Display] text-2xl">{{ $menu->nama }}</h2>
                    <h3 class="text-[#D2691E] font-semibold text-xl mb-2">Rp {{ number_format($menu->harga, 0, ',', '.') }}</h3>
                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                        {!! $menu->deskripsi !!}
                    </p>
                    <select class="w-full p-3 mb-4 border border-gray-300 rounded-lg bg-gray-50" id="size-{{ $menu->id }}">
                        @if($menu->categories->nama === 'Kopi') <!-- Ganti dengan kondisi yang sesuai untuk memeriksa kategori -->
                            <option value="level 0">Level 0</option>
                            <option value="level 1">Level 1 (+Rp 1.000)</option>
                            <option value="level 2">Level 2 (+Rp 2.000)</option>
                        @else
                            <option value="normal">Normal</option>
                            <option value="sedang">Sedang (+Rp 5.000)</option>
                            <option value="besar">Besar (+Rp 10.000)</option>
                        @endif
                    </select>
                    <button class="w-full bg-gradient-to-br from-[#4b2c01] to-[#8B4513] text-white py-3 rounded-full hover:transform hover:translate-y-[-2px] shadow-lg add-to-cart"
                            data-id="{{ $menu->id }}" data-nama="{{ $menu->nama }}" data-harga="{{ $menu->harga }}">
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
            @endif
        @endforeach
    </div>
</div>

    <div class="fixed bottom-8 right-8 bg-white text-white w-16 h-16 rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-all hover :scale-110" id="cartButton">
        🛒
        <span class="absolute top-0 right-0 bg-red-600 text-white text-xs rounded-full px-2 py-1" id="cartBadge">0</span>
    </div>

    <div id="cartModal" class="modal fixed inset-0 bg-black bg-opacity-50 backdrop-blur-md flex items-center justify-center opacity-0 transition-opacity duration-500 hidden">
        <div class="bg-white p-6 rounded-lg max-w-lg w-full shadow-xl modal-content">
            <span class="text-xl font-bold absolute top-4 right-4 cursor-pointer close">&times;</span>
            <h2 class="text-center text-2xl font-semibold mb-4">Keranjang Belanja</h2>
            <div id="cartItems"></div>
            <div class="cart-summary mt-6 bg-gray-100 p-4 rounded-lg text-right">
                <p class="text-xl font-bold">Total: Rp <span id="cartTotal">0</span></p>
                <button id="checkoutButton" class="bg-gradient-to-br from-[#4b2c01] to-[#8B4513] text-white py-2 px-6 rounded-full mt-4 hover:transform hover:translate-y-[-2px] shadow-lg">Checkout</button>
            </div>
        </div>
    </div>

    <div id="notification" class="hidden fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-500">
        Item berhasil ditambahkan ke keranjang!
    </div>


    <footer class="bg-gradient-to-br from-[#4b2c01]/50 to-[#8B4513]/50 text-white py-8 text-center">
        <p>&copy; {{ date('Y') }} Cafe KuyBrew. All rights reserved.</p>
    </footer>

    <script>
    // Menampilkan layar loading
    document.getElementById('loadingScreen').style.display = 'flex';

    function hideLoadingScreen() {
        document.getElementById('loadingScreen').style.display = 'none';
    }

    window.onload = function () {
        setTimeout(hideLoadingScreen, 3000);
    };

    // Cek apakah pengguna sudah login
    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

    function toggleDropdown(dropdownId) {
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('hidden');

        // Handle icons rotation
        if (dropdownId === 'dropdownCategoryMenu') {
            const icon = document.getElementById('dropdownIconCategory');
            icon.classList.toggle('rotate-180');
        }
    }

    function toggleSubmenu(submenuId) {
    const submenu = document.getElementById(submenuId);
    submenu.classList.toggle('hidden');
    }

    window.addEventListener('click', function(event) {
    const dropdownCategory = document.getElementById('dropdownCategoryMenu');
    const dropdownButton = document.querySelector('button');
    
    // Menutup dropdown jika klik di luar tombol dropdown dan dropdown
    if (!dropdownCategory.contains(event.target) && !dropdownButton.contains(event.target)) {
        dropdownCategory.classList.add('hidden');
        const icon = document.getElementById('dropdownIconCategory');
        icon.classList.remove('rotate-180'); // Reset arah ikon
    }

    // Menutup submenu jika klik di luar submenu
    const submenus = document.querySelectorAll('ul[id^="dropdown"]');
    submenus.forEach((submenu) => {
        if (!submenu.contains(event.target) && !submenu.previousElementSibling.contains(event.target)) {
            submenu.classList.add('hidden');
        }
    });
});
    // Close all dropdowns if clicked outside
    window.onclick = function (event) {
        const dropdownCategory = document.getElementById('dropdownCategoryMenu');
        const dropdownUser  = document.getElementById('dropdownUser Menu');

        if (!event.target.closest('button')) {
            if (!dropdownCategory.contains(event.target)) {
                dropdownCategory.classList.add('hidden');
                document.getElementById('dropdownIconCategory').classList.remove('rotate-180');
            }
            if (!dropdownUser .contains(event.target)) {
                dropdownUser .classList.add('hidden');
            }
        }
    };

    // Keranjang belanja
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Fungsi untuk memperbarui badge keranjang
    function updateCartBadge() {
        const badge = document.getElementById('cartBadge');
        const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
        badge.textContent = totalItems;
    }

    // Fungsi menghitung harga berdasarkan ukuran
    function calculateItemPrice(basePrice, size) {
        switch (size) {
            case 'level 1':
                return basePrice + 1000;
            case 'level 2':
                return basePrice + 2000;
            case 'sedang':
                return basePrice + 5000;
            case 'besar':
                return basePrice + 10000;
            default:
                return basePrice;
        }
    }

    // Fungsi memperbarui tampilan keranjang
    function updateCart() {
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        let total = 0;

        cartItems.innerHTML = ''; // Kosongkan elemen keranjang
        cart.forEach((item, index) => {
            const itemTotal = calculateItemPrice(item.harga, item.size) * item.quantity;
            total += itemTotal;

            const itemDiv = document.createElement('div');
            itemDiv.className = 'cart-item flex justify-between items-center border-b py-3';

            itemDiv.innerHTML = `
                <div class="flex-1">
                    <p class="font-semibold">${item.nama} (${item.size})</p>
                    <p class="text-gray-600">Rp ${itemTotal.toLocaleString('id-ID')}</p>
                </div>
                <div class="flex items-center space-x-4">
                    <button onclick="removeItem(${index})" class="px-3 py-1 bg-red-500 text-white rounded-full hover:bg-red-600">
                        <i class="fa fa-trash"></i> Hapus
                    </button>
                    <div class="quantity-controls flex items-center space-x-2">
                        <button onclick="updateQuantity(${index}, -1)" class="px-3 py-1 bg-gray-200 rounded-full hover:bg-gray-300">-</button>
                        <span>${item.quantity}</span>
                        <button onclick="updateQuantity(${index}, 1)" class="px-3 py-1 bg-gray-200 rounded-full hover:bg-gray-300">+</button>
                    </div>
                </div>
            `;
            cartItems.append
            cartItems.appendChild(itemDiv);
        });

        cartTotal.textContent = total.toLocaleString('id-ID');
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartBadge();
    }

    // Fungsi memperbarui jumlah item di keranjang
    function updateQuantity(index, change) {
        cart[index].quantity += change;
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        updateCart();
    }

    // Fungsi menghapus item dari keranjang
    function removeItem(index) {
        cart.splice(index, 1);
        updateCart();
    }

    // Menambahkan item ke keranjang
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', () => {
        if (!isLoggedIn) {
            alert('Anda harus login terlebih dahulu untuk menambahkan item ke keranjang.');
            window.location.href = '/login';
            return;
        }

        const id = button.dataset.id;
        const nama = button.dataset.nama;
        const basePrice = parseInt(button.dataset.harga);
        const size = document.getElementById(`size-${id}`).value;

        // Mengecek apakah stok item masih tersedia
        const availableStock = parseInt(button.dataset.stok); // Ambil stok yang tersedia dari dataset
        const existingItem = cart.find(item => item.id === id && item.size === size);

        if (availableStock <= 0) {
            showOutOfStockNotification(nama);  // Menampilkan notifikasi stok habis
            return; // Jika stok habis, hentikan proses menambahkan ke keranjang
        }

        if (existingItem) {
            // Jika item sudah ada di keranjang, hanya tambahkan quantity
            if (existingItem.quantity < availableStock) {
                existingItem.quantity++;
            } else {
                alert(`Stok untuk ${nama} tidak mencukupi!`);
                return;
            }
        } else {
            // Jika item belum ada di keranjang, tambahkan item baru
            cart.push({
                id,
                nama,
                harga: basePrice,
                size,
                quantity: 1
            });
        }

        updateCart();
    });
});
 
    // Membuka modal keranjang
    document.getElementById('cartButton').onclick = () => {
        const cartModal = document.getElementById('cartModal');
        cartModal.classList.add('show');
        updateCart();
    };

    // Menutup modal keranjang
    document.querySelector('.close').onclick = () => {
        const cartModal = document.getElementById('cartModal');
        cartModal.classList.remove('show');
    };

    // Fungsi checkout
    document.getElementById('checkoutButton').onclick = () => {
        if (cart.length === 0) {
            alert('Keranjang belanja kosong!');
            return;
        }

        const checkoutData = {
            items: cart,
            total: parseFloat(document.getElementById('cartTotal').textContent.replace(/,/g, ''))
        };

        localStorage.setItem('checkoutData', JSON.stringify(checkoutData));
        cart = [];
        localStorage.removeItem('cart');
        updateCart();
        window.location.href = '/checkout';
    };

    // Fungsi untuk menampilkan notifikasi
    function showNotification() {
        const notification = document.getElementById('notification');
        notification.classList.remove('hidden'); // Tampilkan notifikasi
        notification.classList.add('opacity-100'); // Tambahkan efek transisi

        setTimeout(() => {
            notification.classList.add('hidden'); // Sembunyikan setelah 2 detik
            notification.classList.remove('opacity-100');
        }, 2000);
    }

    // Event listener untuk tombol "Tambah ke Keranjang"
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const harga = parseFloat(this.getAttribute('data-harga'));
            const size = document.getElementById(`size-${id}`).value;

            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartBadge();
            showNotification(); // Panggil fungsi notifikasi
        });
    });

    // Inisialisasi awal
    updateCartBadge();
</script>
</body>

</html>