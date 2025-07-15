{{--
    CATATAN: Pastikan Anda mengirimkan variabel `$settings` dari controller ke view ini
    agar logo dan nama pangkalan gas dapat ditampilkan. Contoh di controller:

    public function create()
    {
        $settings = //... Ambil data settings dari database
        return view('auth.register', ['settings' => $settings]);
    }
--}}
<x-guest-layout>
    {{-- STRUKTUR UTAMA: Container full-screen untuk menengahkan konten secara vertikal dan horizontal --}}
    <div class="min-h-screen flex flex-col items-center justify-center bg-slate-100 p-4">

        {{-- Logo Perusahaan --}}
        <div class="mb-8">
            <a href="{{ route('home') }}">
                @if (!empty($settings['logo']))
                    <img src="{{ Storage::url($settings['logo']) }}" alt="Logo" class="h-12 w-auto">
                @else
                    <h1 class="text-2xl font-bold text-slate-700">{{ $settings['base_name'] ?? 'Pangkalan Gas' }}</h1>
                @endif
            </a>
        </div>

        {{-- Kartu Formulir Pendaftaran --}}
        <div class="bg-white p-6 md:p-8 rounded-2xl shadow-xl w-full max-w-4xl">

            {{-- Header Formulir --}}
            <div class="text-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-slate-800">Pendaftaran Member Baru</h2>
                <p class="text-slate-500 mt-1 text-sm md:text-base">Hanya butuh beberapa langkah untuk bergabung.</p>
            </div>

            {{-- Pesan Sukses --}}
            @if (session('success'))
                <div class="mb-4 flex items-center gap-4 font-medium text-sm text-teal-800 bg-teal-100 p-3 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('member.store') }}">
                @csrf

                {{-- PENYESUAIAN: Grid dengan gap yang lebih kecil untuk menghemat ruang --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                    {{-- Nama Lengkap --}}
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" class="text-sm" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="name" class="block w-full pl-10 text-sm" type="text"
                                name="name" :value="old('name')" required autofocus />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-1" />
                    </div>

                    {{-- No. HP --}}
                    <div>
                        <x-input-label for="phone_number" value="No. HP (WhatsApp)" class="text-sm" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                            </div>
                            <x-text-input id="phone_number" class="block w-full pl-10 text-sm" type="tel"
                                name="phone_number" :value="old('phone_number')" required />
                        </div>
                        <x-input-error :messages="$errors->get('phone_number')" class="mt-1" />
                    </div>

                    {{-- No. KTP --}}
                    <div>
                        <x-input-label for="ktp_number" value="No. KTP" class="text-sm" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm1 4a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1V8zm2 2a1 1 0 100 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <x-text-input id="ktp_number" class="block w-full pl-10 text-sm" type="text"
                                name="ktp_number" :value="old('ktp_number')" required />
                        </div>
                        <x-input-error :messages="$errors->get('ktp_number')" class="mt-1" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" value="Email" class="text-sm" />
                        <div class="relative mt-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                </svg>
                            </div>
                            <x-text-input id="email" class="block w-full pl-10 text-sm" type="email"
                                name="email" :value="old('email')" required />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-1" />
                    </div>

                    {{-- Alamat Lengkap (span 2 kolom di desktop) --}}
                    <div class="md:col-span-2">
                        <x-input-label for="address" value="Alamat Lengkap" class="text-sm" />
                        {{-- PENYESUAIAN: rows dikurangi menjadi 2 agar tidak memakan banyak tempat --}}
                        <textarea id="address" name="address" rows="2"
                            class="block mt-1 w-full border-slate-300 focus:border-teal-500 focus:ring-teal-500 rounded-md shadow-sm bg-slate-50 text-sm"
                            required>{{ old('address') }}</textarea>
                        <x-input-error :messages="$errors->get('address')" class="mt-1" />
                    </div>
                </div>

                {{-- Tombol Submit --}}
                <div class="mt-6">
                    <x-primary-button class="w-full justify-center text-base py-2.5">
                        Daftar & Jadi Member
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
