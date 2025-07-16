<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $settings['base_name'] ?? config('app.name', 'Laravel') }}</title>

    {{-- Google Fonts: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Menerapkan font Poppins ke seluruh body */
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-slate-50 text-slate-800">

    {{-- Navbar --}}
    {{-- PENINGKATAN: Navbar dibuat semi-transparan dengan efek blur untuk tampilan modern saat di-scroll --}}
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-slate-200/75">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-xl font-bold text-slate-900">
                @if (!empty($settings['logo']))
                    <img src="{{ Storage::url($settings['logo']) }}" alt="Logo" class="h-12 w-auto">
                @else
                    <h1 class="text-2xl font-bold text-slate-700">{{ $settings['base_name'] ?? 'Pangkalan Gas' }}</h1>
                @endif
            </a>
            <div class="hidden md:flex items-center space-x-2">
                <a href="#produk" class="text-slate-600 hover:text-teal-500 px-4 py-2 transition-colors">Produk</a>
                <a href="#testimoni" class="text-slate-600 hover:text-teal-500 px-4 py-2 transition-colors">Testimoni</a>
                <a href="#kontak" class="text-slate-600 hover:text-teal-500 px-4 py-2 transition-colors">Kontak</a>
            </div>
            <div>
                 <a href="{{ route('member.register') }}" class="bg-teal-500 text-white font-semibold rounded-full px-5 py-2.5 hover:bg-teal-600 transition-all duration-300 shadow-sm hover:shadow-md">
                    Daftar Member
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    {{-- PENINGKATAN: Layout dengan gradien halus, tipografi menonjol dengan teks gradien, dan padding lebih luas --}}
    <header class="relative bg-white overflow-hidden">
        <div class="container mx-auto px-6 py-24 md:py-32">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                {{-- Kolom Kiri: Teks --}}
                <div class="text-center md:text-left">
                    <h1 class="text-4xl md:text-6xl font-extrabold text-slate-900 leading-tight mb-4">
                        <span class="bg-gradient-to-r from-teal-500 to-sky-600 bg-clip-text text-transparent">
                            {{ $settings['base_name'] ?? 'Selamat Datang' }}
                        </span>
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 max-w-lg mx-auto md:mx-0">
                        {{ $settings['slogan'] ?? 'Solusi cepat dan terpercaya untuk semua kebutuhan gas LPG di rumah dan usaha Anda.' }}
                    </p>
                    <a href="#produk" class="inline-block bg-gradient-to-r from-teal-500 to-sky-500 text-white font-bold py-3 px-8 rounded-full hover:scale-105 transform transition-all duration-300 shadow-lg hover:shadow-sky-200">
                        Lihat Produk Kami
                    </a>
                </div>
                {{-- Kolom Kanan: Gambar --}}
                <div class="flex justify-center">
                    @if(!empty($settings['hero_image']))
                        <img src="{{ Storage::url($settings['hero_image']) }}" class="w-full max-w-md h-auto rounded-lg shadow-2xl" alt="Hero Image">
                    @else
                        <div class="w-full h-80 bg-slate-200 rounded-lg shadow-2xl flex items-center justify-center">
                            <span class="text-slate-400">Gambar Hero</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6">
        {{-- Section Keunggulan Kami --}}
        {{-- PENINGKATAN: Mengganti statistik mentah dengan "Keunggulan" yang lebih menjual. Menggunakan ikon SVG profesional. --}}
        <section id="keunggulan" class="py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Keunggulan Kami</h2>
                <p class="text-slate-500 mt-2">Mengapa memilih kami sebagai partner Anda.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                {{-- Card 1: Pelayanan Cepat --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                     <div class="bg-teal-100 text-teal-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800 mb-2">Pelayanan Cepat</h3>
                    <p class="text-slate-500">Pengantaran tepat waktu sesuai jadwal yang Anda tentukan.</p>
                </div>
                {{-- Card 2: Kualitas Terjamin --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="bg-sky-100 text-sky-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800 mb-2">Kualitas Terjamin</h3>
                    <p class="text-slate-500">Produk asli dan ber-SNI, aman untuk keluarga Anda.</p>
                </div>
                {{-- Card 3: Stok Selalu Ada --}}
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="bg-amber-100 text-amber-500 rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4M4 7v10" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-slate-800 mb-2">Stok Selalu Ada</h3>
                    <p class="text-slate-500">Ketersediaan produk yang konsisten untuk segala kebutuhan.</p>
                </div>
            </div>
        </section>

        {{-- Section Statistik --}}
        {{-- BARU: Menambahkan kembali statistik dengan desain yang diperbarui agar selaras dengan tema --}}
        

        {{-- Products Section --}}
        <section id="produk" class="py-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Produk Populer Kami</h2>
                 <p class="text-slate-500 mt-2">Pilihan terbaik yang paling diminati pelanggan.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                    {{-- PENINGKATAN: Desain kartu produk lebih bersih dengan bayangan lebih halus dan tombol CTA --}}
                    <div class="bg-white rounded-xl shadow-md overflow-hidden group transform hover:-translate-y-2 transition-transform duration-300">
                        <div class="overflow-hidden">
                             <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-56 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-slate-500 mb-1">{{ $product->brand->name }} / {{ $product->variant->name }}</p>
                            <h3 class="text-xl font-semibold mb-3 text-slate-800">{{ $product->name }}</h3>
                            <div class="flex justify-between items-center">
                                <div class="text-2xl font-bold text-teal-600">
                                    Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                </div>
                                {{-- <a href="#" class="bg-slate-100 text-slate-700 text-sm font-semibold px-4 py-2 rounded-lg hover:bg-teal-500 hover:text-white transition-colors">Pesan</a> --}}
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-slate-500">Produk belum tersedia.</p>
                @endforelse
            </div>
        </section>

        {{-- Testimonials Section --}}
        <section id="testimoni" class="py-16 bg-slate-100 -mx-6 px-6 rounded-2xl">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-slate-900">Apa Kata Mereka?</h2>
                <p class="text-slate-500 mt-2">Pengalaman nyata dari para pelanggan setia kami.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($testimonials as $testimonial)
                    {{-- PENINGKATAN: Kartu testimoni dengan ikon kutip sebagai elemen desain latar belakang --}}
                    <div class="bg-white p-8 rounded-xl shadow-lg relative overflow-hidden">
                         <svg class="absolute top-0 left-0 w-24 h-24 text-slate-50 opacity-50 transform -translate-x-4 -translate-y-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 13V5a2 2 0 00-2-2H4a2 2 0 00-2 2v8a2 2 0 002 2h3l3 3 3-3h3a2 2 0 002-2zM5 7a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1zm1 3a1 1 0 100 2h3a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                        <div class="relative z-10">
                            <div class="flex items-center mb-4">
                                <img class="w-14 h-14 rounded-full object-cover mr-4 ring-2 ring-teal-200" src="{{ $testimonial->customer_image ? Storage::url($testimonial->customer_image) : asset('images/default-avatar.png') }}">
                                <div>
                                    <h4 class="font-bold text-slate-800">{{ $testimonial->user->name }}</h4>
                                    <p class="text-sm text-slate-500">{{ $testimonial->customer_job }}</p>
                                </div>
                            </div>
                            <p class="text-slate-600 mb-4 italic">"{{ $testimonial->comment }}"</p>
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-5 h-5 {{ $i <= $testimonial->rating ? 'text-amber-400' : 'text-slate-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-slate-500">Belum ada testimoni.</p>
                @endforelse
            </div>
        </section>
        <section id="statistik" class="py-16 bg-slate-100 -mx-6 px-6 rounded-2xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                {{-- Card 1: Puas --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl text-teal-500 mb-2">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <p class="text-4xl font-bold text-slate-800">{{ $satisfiedPercentage }}%</p>
                    <p class="text-slate-500">Pelanggan Puas</p>
                </div>
                {{-- Card 2: Kualitas --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl text-amber-500 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                    </div>
                    <p class="text-4xl font-bold text-slate-800">{{ $averageRatingFormatted }}/5.0</p>
                    <p class="text-slate-500">Rata-rata Kualitas</p>
                </div>
                {{-- Card 3: Produk Tersedia --}}
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="text-4xl text-sky-500 mb-2">
                         <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" /></svg>
                    </div>
                    <p class="text-4xl font-bold text-slate-800">{{ $productsAvailable }}</p>
                    <p class="text-slate-500">Jenis Produk</p>
                </div>
            </div>
        </section>
    </main>

    {{-- Footer --}}
    {{-- PENINGKATAN: Warna footer diganti menjadi lebih gelap (slate), tata letak disesuaikan untuk keterbacaan yang lebih baik --}}
    <footer id="kontak" class="bg-slate-900 text-slate-300">
        <div class="container mx-auto px-6 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                {{-- Kolom 1: Tentang Kami --}}
                <div class="col-span-1 md:col-span-2">
                    <h3 class="font-bold text-lg text-white mb-2">{{ $settings['base_name'] ?? 'Pangkalan Gas' }}</h3>
                    <p class="text-slate-400 max-w-md">{{ $settings['slogan'] ?? 'Solusi kebutuhan gas LPG Anda' }}</p>
                </div>
                {{-- Kolom 2: Kontak --}}
                <div>
                    <h3 class="font-bold text-lg text-white mb-2">Kontak Kami</h3>
                    <ul class="space-y-2 text-slate-400">
                        <li>Alamat: {{ $settings['address'] ?? '-' }}</li>
                        <li>Email: {{ $settings['email'] ?? '-' }}</li>
                        <li>Telepon: {{ $settings['phone'] ?? '-' }}</li>
                    </ul>
                </div>
                {{-- Kolom 3: Tautan --}}
                <div>
                    <h3 class="font-bold text-lg text-white mb-2">Tautan</h3>
                     <ul class="space-y-2">
                        <li><a href="#produk" class="text-slate-400 hover:text-teal-400 transition-colors">Produk</a></li>
                        <li><a href="#testimoni" class="text-slate-400 hover:text-teal-400 transition-colors">Testimoni</a></li>
                        <li><a href="{{ route('member.register') }}" class="text-slate-400 hover:text-teal-400 transition-colors">Daftar Member</a></li>
                    </ul>
                </div>
            </div>
            <div class="mt-10 border-t border-slate-800 text-center pt-8">
                <p class="text-slate-500">&copy; {{ date('Y') }} {{ $settings['base_name'] ?? config('app.name') }}. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>