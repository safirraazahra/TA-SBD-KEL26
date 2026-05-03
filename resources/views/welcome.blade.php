<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrintHub - Jasa Print & Fotocopy Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .card-hover { transition: all 0.3s; }
        .card-hover:hover { transform: translateY(-6px); box-shadow: 0 25px 50px rgba(0,0,0,0.12); }
        .float-anim { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-20px)} }
        .blob { border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%; }
        nav { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white">
    <nav class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl hero-gradient flex items-center justify-center">
                    <i class="fas fa-print text-white"></i>
                </div>
                <span class="text-xl font-bold text-gray-800">Print<span class="text-indigo-600">Hub</span></span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">Masuk</a>
                <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-semibold text-white rounded-xl hero-gradient hover:opacity-90 transition-all shadow-lg shadow-indigo-200">Daftar Gratis</a>
            </div>
        </div>
    </nav>

    <section class="hero-gradient min-h-screen flex items-center pt-20 overflow-hidden relative">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 right-40 w-96 h-96 bg-white blob float-anim"></div>
            <div class="absolute bottom-20 left-40 w-64 h-64 bg-white blob float-anim" style="animation-delay:3s"></div>
        </div>
        <div class="max-w-7xl mx-auto px-6 py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-white">
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm font-medium mb-6">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Platform Print Online Terpercaya
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Print & Fotocopy<br><span class="text-yellow-300">Kapan Saja,</span><br>Di Mana Saja
                    </h1>
                    <p class="text-white/80 text-xl leading-relaxed mb-10">Pesan jasa cetak dokumen, fotocopy, jilid, dan laminating secara online. Pilih toko terdekat, upload file, dan terima pesananmu!</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-2xl hover:shadow-2xl transition-all hover:-translate-y-1 text-lg"><i class="fas fa-rocket mr-2"></i>Mulai Sekarang</a>
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-white/20 backdrop-blur-sm text-white font-semibold rounded-2xl hover:bg-white/30 transition-all text-lg border border-white/30"><i class="fas fa-sign-in-alt mr-2"></i>Masuk</a>
                    </div>
                    <div class="flex items-center gap-8 mt-12">
                        <div class="text-center"><p class="text-3xl font-bold">500+</p><p class="text-white/70 text-sm">Pelanggan</p></div>
                        <div class="w-px h-12 bg-white/30"></div>
                        <div class="text-center"><p class="text-3xl font-bold">50+</p><p class="text-white/70 text-sm">Toko Print</p></div>
                        <div class="w-px h-12 bg-white/30"></div>
                        <div class="text-center"><p class="text-3xl font-bold">10K+</p><p class="text-white/70 text-sm">Pesanan</p></div>
                    </div>
                </div>
                <div class="hidden lg:flex justify-center">
                    <div class="w-80 h-80 bg-white/10 rounded-3xl backdrop-blur-sm p-8 border border-white/20 space-y-4">
                        <div class="flex items-center gap-3 bg-white/20 rounded-2xl p-4">
                            <div class="w-10 h-10 bg-yellow-400 rounded-xl flex items-center justify-center"><i class="fas fa-file-alt text-white"></i></div>
                            <div><p class="text-white font-semibold text-sm">Skripsi.pdf</p><p class="text-white/60 text-xs">120 halaman • Jilid soft cover</p></div>
                            <span class="ml-auto text-green-400 text-xs font-bold">✓ Siap</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/20 rounded-2xl p-4">
                            <div class="w-10 h-10 bg-blue-400 rounded-xl flex items-center justify-center"><i class="fas fa-image text-white"></i></div>
                            <div><p class="text-white font-semibold text-sm">Banner 2x1m</p><p class="text-white/60 text-xs">Full color • Laminasi glossy</p></div>
                            <span class="ml-auto text-yellow-400 text-xs font-bold">⟳ Proses</span>
                        </div>
                        <div class="flex items-center gap-3 bg-white/20 rounded-2xl p-4">
                            <div class="w-10 h-10 bg-green-400 rounded-xl flex items-center justify-center"><i class="fas fa-copy text-white"></i></div>
                            <div><p class="text-white font-semibold text-sm">Fotocopy Rapor</p><p class="text-white/60 text-xs">50 lembar • Hitam putih</p></div>
                            <span class="ml-auto text-green-400 text-xs font-bold">✓ Selesai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14"><h2 class="text-4xl font-bold text-gray-800 mb-4">Layanan Kami</h2><p class="text-gray-500 text-lg">Semua kebutuhan cetak tersedia di sini</p></div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach([['fa-file-alt','bg-blue-500','Print Dokumen','HVS, A4, F4'],['fa-palette','bg-pink-500','Print Berwarna','Full color'],['fa-copy','bg-green-500','Fotocopy','Cepat & murah'],['fa-book','bg-orange-500','Jilid','Soft & hard cover'],['fa-layer-group','bg-purple-500','Laminating','Glossy & doff'],['fa-qrcode','bg-teal-500','Scan','Resolusi tinggi'],['fa-image','bg-red-500','Banner','Cetak besar'],['fa-plus-circle','bg-gray-500','Lainnya','Hubungi kami']] as [$icon,$color,$label,$desc])
                <div class="card-hover bg-white rounded-2xl p-6 text-center shadow-sm border border-gray-100">
                    <div class="w-14 h-14 {{ $color }} rounded-2xl flex items-center justify-center mx-auto mb-4"><i class="fas {{ $icon }} text-white text-xl"></i></div>
                    <h3 class="font-bold text-gray-800 mb-1">{{ $label }}</h3>
                    <p class="text-gray-400 text-sm">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-14"><h2 class="text-4xl font-bold text-gray-800 mb-4">Cara Kerja</h2><p class="text-gray-500 text-lg">Pesan jasa print hanya 4 langkah mudah</p></div>
            <div class="grid md:grid-cols-4 gap-8">
                @foreach([['1','fa-user-plus','from-blue-400 to-blue-600','Daftar Akun','Buat akun sebagai Pembeli'],['2','fa-search','from-purple-400 to-purple-600','Pilih Layanan','Temukan jasa sesuai kebutuhan'],['3','fa-credit-card','from-pink-400 to-pink-600','Bayar','Transfer bank, e-wallet, COD'],['4','fa-box-open','from-green-400 to-green-600','Terima Pesanan','Ambil atau dikirim ke lokasimu']] as [$step,$icon,$grad,$title,$desc])
                <div class="text-center">
                    <div class="w-16 h-16 bg-gradient-to-br {{ $grad }} rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg"><i class="fas {{ $icon }} text-white text-2xl"></i></div>
                    <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center mx-auto -mt-2 mb-3 text-sm font-bold text-gray-600">{{ $step }}</div>
                    <h3 class="font-bold text-gray-800 mb-2 text-lg">{{ $title }}</h3>
                    <p class="text-gray-400">{{ $desc }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 hero-gradient">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-white mb-6">Siap Mulai? Daftar Gratis Sekarang!</h2>
            <p class="text-white/80 text-xl mb-10">Bergabung dengan ribuan pengguna PrintHub.</p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white text-indigo-700 font-bold rounded-2xl hover:shadow-2xl transition-all hover:-translate-y-1 text-lg"><i class="fas fa-shopping-cart mr-2"></i>Daftar sebagai Pembeli</a>
                <a href="{{ route('register') }}" class="px-8 py-4 bg-white/20 border border-white/40 text-white font-bold rounded-2xl hover:bg-white/30 transition-all text-lg"><i class="fas fa-store mr-2"></i>Buka Toko Print</a>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-10">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-8 h-8 rounded-lg hero-gradient flex items-center justify-center"><i class="fas fa-print text-white text-xs"></i></div>
                <span class="font-bold text-lg">Print<span class="text-indigo-400">Hub</span></span>
            </div>
            <p class="text-gray-400">Sistem Pemesanan Jasa Print dan Fotocopy Online</p>
            <p class="text-gray-600 text-sm mt-3">&copy; {{ date('Y') }} PrintHub. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
