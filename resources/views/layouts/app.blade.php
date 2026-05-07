<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PrintHub') - Jasa Print & Fotocopy Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { poppins: ['Poppins', 'sans-serif'] },
                    colors: {
                        primary: { 50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',800:'#3730a3',900:'#312e81' },
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .nav-link { transition: all 0.2s ease; }
        .nav-link:hover { background-color: rgba(99,102,241,0.1); color: #4f46e5; }
        .nav-link.active { background-color: rgba(99,102,241,0.15); color: #4338ca; font-weight: 600; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.12); }
        .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .sidebar-link { transition: all 0.2s; border-radius: 10px; }
        .sidebar-link:hover, .sidebar-link.active { background: linear-gradient(135deg, #667eea, #764ba2); color: white; }
    </style>
    @yield('styles')
</head>
<body class="h-full bg-gray-50">

<!-- Top Navbar -->
<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl gradient-bg flex items-center justify-center">
                    <i class="fas fa-print text-white text-sm"></i>
                </div>
                <a href="/" class="text-xl font-bold text-gray-800">Print<span class="text-primary-600">Hub</span></a>
            </div>

            <!-- Nav Links -->
            <div class="hidden md:flex items-center gap-1">
                @auth
                    @if(auth()->user()->isBuyer())
                        <a href="{{ route('buyer.dashboard') }}" class="nav-link px-4 py-2 rounded-lg text-sm text-gray-600 {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home mr-1"></i> Dashboard
                        </a>
                        <a href="{{ route('buyer.services') }}" class="nav-link px-4 py-2 rounded-lg text-sm text-gray-600 {{ request()->routeIs('buyer.services*') ? 'active' : '' }}">
                            <i class="fas fa-store mr-1"></i> Layanan
                        </a>
                        <a href="{{ route('buyer.orders') }}" class="nav-link px-4 py-2 rounded-lg text-sm text-gray-600 {{ request()->routeIs('buyer.orders*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-bag mr-1"></i> Pesanan Saya
                        </a>
                    @else
                        <a href="{{ route('seller.dashboard') }}" class="nav-link px-4 py-2 rounded-lg text-sm text-gray-600 {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-chart-bar mr-1"></i> Dashboard
                        </a>
                        <a href="{{ route('seller.services') }}" class="nav-link px-4 py-2 rounded-lg text-sm text-gray-600 {{ request()->routeIs('seller.services*') ? 'active' : '' }}">
                            <i class="fas fa-box mr-1"></i> Layanan Saya
                        </a>
                        <a href="{{ route('seller.orders') }}" class="nav-link px-4 py-2 rounded-lg text-sm text-gray-600 {{ request()->routeIs('seller.orders*') ? 'active' : '' }}">
                            <i class="fas fa-clipboard-list mr-1"></i> Pesanan Masuk
                        </a>
                        <a href="{{ route('seller.orders.report') }}" class="nav-link px-4 py-2 rounded-lg text-sm text-gray-600 {{ request()->routeIs('seller.orders.report') ? 'active' : '' }}">
                            <i class="fas fa-file-alt mr-1"></i> Laporan
                        </a>
                    @endif
                @endauth
            </div>

            <!-- User Menu -->
            <div class="flex items-center gap-3">
                @auth
                    <div class="relative group">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-xl bg-gray-50 hover:bg-gray-100 transition-all">
                            <div class="w-8 h-8 rounded-full gradient-bg flex items-center justify-center text-white text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role === 'buyer' ? 'Pembeli' : 'Penjual' }}</p>
                            </div>
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                            <div class="p-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="p-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm text-primary-600 font-medium hover:bg-primary-50 rounded-lg transition-all">Masuk</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm text-white font-medium rounded-lg gradient-bg hover:opacity-90 transition-all">Daftar</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
@if(session('success'))
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" id="flash-msg">
    <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800">
        <i class="fas fa-check-circle text-green-500 text-lg"></i>
        <span class="text-sm font-medium">{{ session('success') }}</span>
        <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto text-green-500 hover:text-green-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif
@if(session('error'))
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-4" id="flash-error">
    <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl text-red-800">
        <i class="fas fa-exclamation-circle text-red-500 text-lg"></i>
        <span class="text-sm font-medium">{{ session('error') }}</span>
        <button onclick="document.getElementById('flash-error').remove()" class="ml-auto text-red-500 hover:text-red-700">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endif

<!-- Page Content -->
<main>
    @yield('content')
</main>

<!-- Footer -->
<footer class="bg-white border-t border-gray-100 mt-16">
    <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg gradient-bg flex items-center justify-center">
                    <i class="fas fa-print text-white text-xs"></i>
                </div>
                <span class="font-bold text-gray-700">Print<span class="text-primary-600">Hub</span></span>
                <span class="text-gray-400 text-sm">- Sistem Pemesanan Jasa Print & Fotocopy Online</span>
            </div>
            <p class="text-gray-400 text-sm">&copy; {{ date('Y') }} PrintHub. All rights reserved.</p>
        </div>
    </div>
</footer>

@yield('scripts')
</body>
</html>
