<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PrintHub</title>
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
                        primary: { 50:'#eef2ff',100:'#e0e7ff',500:'#6366f1',600:'#4f46e5',700:'#4338ca' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .auth-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .input-focus:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.15); outline: none; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); transition: all 0.3s; }
        .btn-primary:hover { opacity: 0.92; transform: translateY(-1px); box-shadow: 0 8px 25px rgba(102,126,234,0.4); }
        .floating-label { transition: all 0.2s ease; }
        .role-card { transition: all 0.3s; cursor: pointer; }
        .role-card:hover { border-color: #6366f1; background: rgba(99,102,241,0.05); }
        .role-card.selected { border-color: #4f46e5; background: rgba(99,102,241,0.08); }
    </style>
</head>
<body class="min-h-screen flex">
    <!-- Left Panel -->
    <div class="hidden lg:flex lg:w-1/2 auth-gradient flex-col justify-between p-12 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-64 h-64 bg-white rounded-full"></div>
            <div class="absolute bottom-20 right-20 w-48 h-48 bg-white rounded-full"></div>
            <div class="absolute top-1/2 left-1/2 w-32 h-32 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-3 mb-16">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                    <i class="fas fa-print text-white text-xl"></i>
                </div>
                <span class="text-white text-2xl font-bold">PrintHub</span>
            </div>
            <h1 class="text-4xl font-bold text-white leading-tight mb-6">
                Solusi Print &<br>Fotocopy Mudah<br>dalam Genggaman
            </h1>
            <p class="text-white/80 text-lg leading-relaxed">
                Pesan jasa cetak, fotocopy, jilid, dan laminating dari mana saja. Kualitas terjamin, harga transparan, pengiriman cepat.
            </p>
        </div>
        <div class="relative z-10 grid grid-cols-3 gap-4">
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 text-center">
                <p class="text-3xl font-bold text-white">500+</p>
                <p class="text-white/70 text-xs mt-1">Pelanggan</p>
            </div>
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 text-center">
                <p class="text-3xl font-bold text-white">50+</p>
                <p class="text-white/70 text-xs mt-1">Toko Print</p>
            </div>
            <div class="bg-white/15 backdrop-blur-sm rounded-2xl p-4 text-center">
                <p class="text-3xl font-bold text-white">99%</p>
                <p class="text-white/70 text-xs mt-1">Kepuasan</p>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="w-full max-w-md">
            <!-- Mobile Logo -->
            <div class="flex lg:hidden items-center gap-3 mb-8 justify-center">
                <div class="w-10 h-10 rounded-2xl auth-gradient flex items-center justify-center">
                    <i class="fas fa-print text-white"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">Print<span class="text-indigo-600">Hub</span></span>
            </div>

            @yield('content')
        </div>
    </div>
</body>
</html>
