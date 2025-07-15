<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    {{-- Google Fonts: Poppins --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Alpine.js untuk interaktivitas --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="antialiased bg-slate-100">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">

        {{-- Overlay untuk menutup sidebar di mobile --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 bg-black bg-opacity-50 z-20 md:hidden" x-transition.opacity></div>

        {{-- Sidebar --}}
        <aside
            class="w-64 bg-white text-slate-600 flex flex-col flex-shrink-0 fixed inset-y-0 left-0 z-30 transform -translate-x-full transition-transform duration-300 ease-in-out border-r border-slate-200 md:relative md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            {{-- Logo Area --}}
            <div class="h-16 flex items-center px-4 border-b border-slate-200">
                <a href="{{ route('home') }}" class="flex items-center gap-3 w-full overflow-hidden">
                    @if (!empty($settings['logo']))
                        <img src="{{ Storage::url($settings['logo']) }}" alt="Logo"
                            class="h-8 w-auto flex-shrink-0">
                    @endif
                    <span class="text-lg font-bold text-slate-800 truncate">
                        {{ $settings['base_name'] ?? 'Pangkalan Gas' }}
                    </span>
                </a>
            </div>

            {{-- Menu Navigasi (Logika Langsung di Sini) --}}
            {{-- Menu Navigasi (Logika Langsung di Sini) --}}
            <nav class="flex-grow p-4 space-y-1 text-sm">

                {{-- Link: Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" @class([
                    'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200',
                    'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600' => request()->routeIs(
                        'admin.dashboard'),
                    'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                        'admin.dashboard'),
                ])>
                    <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="truncate">Dashboard</span>
                </a>

                {{-- Dropdown: Manajemen Produk --}}
                @php
                    $isProductActive = request()->routeIs(['products.*', 'variants.*', 'brands.*']);
                @endphp
                <div x-data="{ open: {{ $isProductActive ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                            </svg>
                            <span class="truncate">Manajemen Produk</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1">
                        <a href="{{ route('products.index') }}" @class([
                            'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 pl-11',
                            'font-semibold bg-blue-50 text-blue-600' => request()->routeIs(
                                'products.*'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                                'products.*'),
                        ])><span
                                class="truncate">Produk</span></a>
                        <a href="{{ route('variants.index') }}" @class([
                            'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 pl-11',
                            'font-semibold bg-blue-50 text-blue-600' => request()->routeIs(
                                'variants.*'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                                'variants.*'),
                        ])><span
                                class="truncate">Varian</span></a>
                        <a href="{{ route('brands.index') }}" @class([
                            'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 pl-11',
                            'font-semibold bg-blue-50 text-blue-600' => request()->routeIs('brands.*'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                                'brands.*'),
                        ])><span
                                class="truncate">Merek</span></a>
                    </div>
                </div>

                {{-- Link: Transaksi --}}
                <a href="{{ route('transactions.index') }}" @class([
                    'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200',
                    'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600' => request()->routeIs(
                        'transactions.*'),
                    'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                        'transactions.*'),
                ])>
                    <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-1.5h5.25m-5.25 0h5.25m-5.25 0h5.25m-5.25 0h5.25M3 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H3a2.25 2.25 0 0 1-2.25-2.25V6.75A2.25 2.25 0 0 1 3 4.5Z" />
                    </svg>
                    <span class="truncate">Transaksi</span>
                </a>

                {{-- Dropdown: Member --}}
                @php
                    $isMemberActive = request()->routeIs(['members.*']);
                @endphp
                <div x-data="{ open: {{ $isMemberActive ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-2.272M15 19.128v-3.872M15 19.128A9.37 9.37 0 0 1 12.125 21a9.37 9.37 0 0 1-2.875-1.872M15 15.256A9.37 9.37 0 0 1 12.125 18a9.37 9.37 0 0 1-2.875-2.744M12 12.875A3.375 3.375 0 0 0 9 9.5a3.375 3.375 0 0 0-3-3.375M12 12.875c0 .621.504 1.125 1.125 1.125h3.375c.621 0 1.125-.504 1.125-1.125M12 12.875v-3.375a3.375 3.375 0 0 1 3.375-3.375h.5c.331 0 .658.055.958.158A9.38 9.38 0 0 1 21 12.125v3.375c0 .621-.504 1.125-1.125 1.125h-3.375c-.621 0-1.125-.504-1.125-1.125Z" />
                            </svg>
                            <span class="truncate">Member</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1">
                        <a href="{{ route('members.pending') }}" @class([
                            'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 pl-11',
                            'font-semibold bg-blue-50 text-blue-600' => request()->routeIs(
                                'members.pending'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                                'members.pending'),
                        ])><span
                                class="truncate">Persetujuan</span></a>
                        <a href="{{ route('members.index') }}" @class([
                            'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 pl-11',
                            'font-semibold bg-blue-50 text-blue-600' => request()->routeIs(
                                'members.index'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                                'members.index'),
                        ])><span
                                class="truncate">Daftar Member</span></a>
                    </div>
                </div>

                {{-- Dropdown: Laporan --}}
                @php
                    $isReportActive = request()->routeIs(['reports.*']);
                @endphp
                <div x-data="{ open: {{ $isReportActive ? 'true' : 'false' }} }">
                    <button @click="open = !open"
                        class="flex items-center justify-between gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                            </svg>
                            <span class="truncate">Laporan</span>
                        </div>
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse class="mt-1 space-y-1">
                        <a href="{{ route('reports.sales') }}" @class([
                            'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 pl-11',
                            'font-semibold bg-blue-50 text-blue-600' => request()->routeIs(
                                'reports.sales'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                                'reports.sales'),
                        ])><span
                                class="truncate">Laporan Penjualan</span></a>
                        <a href="{{ route('reports.profit_loss') }}" @class([
                            'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200 pl-11',
                            'font-semibold bg-blue-50 text-blue-600' => request()->routeIs(
                                'reports.profit_loss'),
                            'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                                'reports.profit_loss'),
                        ])><span
                                class="truncate">Laporan Laba Rugi</span></a>
                    </div>
                </div>

                {{-- Link: Testimoni --}}
                <a href="{{ route('testimonials.index') }}" @class([
                    'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200',
                    'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600' => request()->routeIs(
                        'testimonials.*'),
                    'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                        'testimonials.*'),
                ])>
                    <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 21.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                    <span class="truncate">Testimoni</span>
                </a>

                {{-- Link: Pengaturan --}}
                <a href="{{ route('settings.index') }}" @class([
                    'flex items-center gap-3 w-full px-4 py-2.5 rounded-md transition-colors duration-200',
                    'font-semibold bg-blue-50 text-blue-600 border-l-4 border-blue-600' => request()->routeIs(
                        'settings.*'),
                    'text-slate-600 hover:bg-slate-100 hover:text-slate-900' => !request()->routeIs(
                        'settings.*'),
                ])>
                    <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.438.995s.145.755.438.995l1.003.827c.447.368.52.984.26 1.431l-1.296 2.247a1.125 1.125 0 0 1-1.37.49l-1.217-.456c-.355-.133-.75-.072-1.075.124a6.57 6.57 0 0 1-.22.127c-.332.183-.582.495-.645.87l-.213 1.281c-.09.543-.56.94-1.11.94h-2.593c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.063-.374-.313-.686-.645-.87a6.52 6.52 0 0 1-.22-.127c-.324-.196-.72-.257-1.075-.124l-1.217.456a1.125 1.125 0 0 1-1.37-.49l-1.296-2.247a1.125 1.125 0 0 1 .26-1.431l1.003-.827c.293-.24.438-.613.438-.995s-.145-.755-.438-.995l-1.003-.827a1.125 1.125 0 0 1-.26-1.431l1.296-2.247a1.125 1.125 0 0 1 1.37-.49l1.217.456c.355.133.75.072 1.075-.124a6.57 6.57 0 0 1 .22-.127c.332-.183.582-.495.645-.87l.213-1.281Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span class="truncate">Pengaturan</span>
                </a>

            </nav>

            {{-- Footer dengan profil pengguna --}}
            <div class="p-4 border-t border-slate-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-2">
                            <img class="h-10 w-10 rounded-full object-cover flex-shrink-0"
                                src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3B82F6&color=fff"
                                alt="{{ Auth::user()->name }}">

                            <div class="flex-1 overflow-hidden">
                                <h4 class="text-sm font-semibold text-slate-800 truncate"
                                    title="{{ Auth::user()->email }}">
                                    {{ Auth::user()->name }}
                                </h4>
                            </div>
                        </a>

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); this.closest('form').submit();" title="Logout"
                            class="text-slate-500 hover:text-slate-800 transition-colors">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                            </svg>
                        </a>
                    </div>
                </form>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm border-b border-slate-200">
                <div class="max-w-7xl mx-auto py-4 px-4 md:px-6 lg:px-8 flex items-center justify-between">
                    <h1 class="text-xl md:text-2xl font-bold text-slate-800">
                        @yield('header', 'Dashboard')
                    </h1>

                    <button @click="sidebarOpen = !sidebarOpen" class="text-slate-500 hover:text-slate-700 md:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7"></path>
                        </svg>
                    </button>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100 p-4 md:p-6">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
