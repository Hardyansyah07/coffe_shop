<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cafe KuyBrew') }} - Cafe KuyBrew Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom color variables */
        :root {
            --primary-color: #4b2c01;
            --secondary-color: #8B4513;
            --accent-color: #000000;
            --light-color: #FFF8DC;
        }
        
        nav {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: #4b2c01;
            color: #FFF8DC;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            margin-bottom: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #FFF8DC;
            transition: color 0.2s ease;
        }

        nav ul li a:hover {
            color: #8B4513;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-[#FFF8DC] font-[Poppins] text-[#2c1810] min-h-screen flex flex-col">
    <div id="app" class="flex min-h-screen">

        <!-- Sidebar Navbar -->
<nav class="bg-[var(--primary-color)] text-[var(--light-color)] shadow-md w-64 p-6 flex flex-col">
    <!-- Brand -->
    <a href="{{ url('/') }}" class="font-bold text-xl flex items-center mb-8">
        <i class="fas fa-coffee mr-2"></i>Cafe KuyBrew
    </a>

    <ul class="nav flex-col space-y-2">
        @if(auth()->check() && auth()->user()->role === 'admin')
            <li>
                <a class="nav-link flex items-center p-2 rounded-md hover:bg-gray-700" href="{{ route('admin.orders.dashboard') }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                </a>
            </li>
            <li>
                <a class="nav-link flex items-center p-2 rounded-md hover:bg-gray-700" href="{{ route('admin.menu.index') }}">
                    <i class="fas fa-utensils mr-3"></i>Menu
                </a>
            </li>
            <li>
                <a class="nav-link flex items-center p-2 rounded-md hover:bg-gray-700" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-list-alt mr-3"></i>Daftar Kategori
                </a>
            </li>
            <li>
                <a class="nav-link flex items-center p-2 rounded-md hover:bg-gray-700 relative" href="{{ route('admin.orders') }}">
                    <i class="fas fa-wallet mr-3"></i> Daftar Pesanan
                    @if($newOrdersCount > 0)
                        <span class="bg-red-500 text-white text-xs font-bold rounded-full px-2 py-1 absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2">
                            {{ $newOrdersCount }}
                        </span>
                    @endif
                </a>
            </li>
            <li>
                <a class="nav-link flex items-center p-2 rounded-md hover:bg-gray-700" href="{{ route('admin.sales_reports.index') }}">
                    <i class="fas fa-file-invoice-dollar mr-3"></i>Laporan Penjualan
                </a>
            </li>
            <li>
                <a class="nav-link flex items-center p-2 rounded-md hover:bg-gray-700 relative" href="{{ route('admin.users') }}">
                    <i class="fas fa-user mr-3"></i> Daftar Pengguna
                    @if($newUsersCount > 0)
                        <span class="bg-blue-500 text-white text-xs font-bold rounded-full px-2 py-1 absolute top-0 right-0 transform translate-x-1/2 -translate-y-1/2">
                            {{ $newUsersCount }}
                        </span>
                    @endif
                </a>
            </li>
        @endif
    </ul>
</nav>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">

            <!-- User Section (Top Right) -->
            <div class="flex justify-end bg-white p-4 shadow-md">
                <ul class="flex space-x-4 text-right">
                    @guest
                        @if (Route::has('login'))
                            <li>
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-[var(--accent-color)] transition">{{ __('Login') }}</a>
                            </li>
                        @endif
                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}" class="text-gray-700 hover:text-[var(--accent-color)] transition">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li>
                            <a href="#" class="text-gray-700 hover:text-[var(--accent-color)] transition">
                                <i class="fas fa-user-circle mr-1"></i>{{ Auth::user()->name }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}" 
                               class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded-md transition"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                               <i class="fas fa-sign-out-alt mr-1"></i>{{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
            <!-- Main Content -->
            <main class="flex-1 py-8 px-4">
                @yield('content')
            </main>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert')
    @yield('scripts')
    @stack('js')
</body>

</html>