<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Store - Cafe KuyBrew</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
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
</style>

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
    
<div class="flex flex-col items-center justify-start mt-12 mb-8 bg-gradient-to-br from-[#4b2c01]/30 to-[#8B4513]/30 py-4 text-center">
    <div class="bg-[#F7E8D7] p-8 rounded-lg shadow-lg max-w-md w-full border border-[#E0C9B0]">
        <h1 class="font-[Playfair Display] text-3xl font-bold mb-4 uppercase">Silakan Masuk</h1>
        <h2 class="text-xl mb-6 font-semibold">Kami Buka</h2>
        <div class="bg-[#F2DFBF] p-6 rounded-lg shadow-md">
            <table class="w-full text-left text-[#2c1810]">
                <tbody>
                    <tr>
                        <td class="py-1">Minggu</td>
                        <td class="py-1 text-right">Tutup</td>
                    </tr>
                    <tr>
                        <td class="py-1">Senin - Jumat</td>
                        <td class="py-1 text-right">07:00 - 20:00</td>
                    </tr>
                    <tr>
                        <td class="py-1">Sabtu</td>
                        <td class="py-1 text-right">09:00 - 23:00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-sm text-[#2c1810]">
            <p class="font-bold">Rancamanyar</p>
            <p>Kabupaten Bandung, Jawa Barat</p>
            <p class="mt-2">Hubungi Kami</p>
            <p>+62 890 123 1666</p>
        </div>
    </div>
</div>
<script>
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

    // Optional: Close the dropdown if clicked outside
    window.onclick = function(event) {
        const dropdownMenu = document.getElementById('dropdownMenu');
        const button = event.target.closest('button');

        if (!button && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
            const dropdownIcon = document.getElementById('dropdownIcon');
            dropdownIcon.classList.remove('rotate-180');
        }
    }
</script>

<footer class="bg-gradient-to-br from-[#4b2c01]/50 to-[#8B4513]/50 text-white py-8 text-center">
        <p>&copy; {{ date('Y') }} Cafe KuyBrew. All rights reserved.</p>
    </footer>

</body>

</html>
