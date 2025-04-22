<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>CAFFE BrewTopia - Admin</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery & Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --primary-color: #000000;
            --secondary-color: #333333;
            --accent-color: #555555;
            --light-color: #ffffff;
        }

        nav {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            background-color: var(--primary-color);
            color: var(--light-color);
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
            color: var(--light-color);
            transition: color 0.2s ease;
        }

        nav ul li a:hover {
            color: var(--secondary-color);
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
<body class="bg-[var(--light-color)] font-[Poppins] text-[var(--primary-color)] min-h-screen flex flex-col">
    <div id="app" class="flex min-h-screen">

        <!-- Sidebar Navbar -->
        <nav class="bg-[var(--primary-color)] text-[var(--light-color)] shadow-md w-64 p-6 flex flex-col">
            <a href="{{ url('/') }}" class="font-bold text-xl flex items-center mb-8">
                <i class="fas fa-coffee mr-2"></i>CAFFE BrewTopia
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

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1 py-8 px-4">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts tambahan dari halaman -->
    @yield('scripts')

</body>
</html>
