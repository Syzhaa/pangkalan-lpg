@extends('layouts.admin')
@section('header', 'Daftar Member Aktif')

@section('content')
    <div class="bg-slate-50 min-h-screen">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <!-- Page Header -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">Member Aktif</h1>
                    <p class="mt-1 text-sm text-slate-500">Daftar semua member yang telah disetujui dan aktif.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('members.create') }}"
                        class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        <span>Tambah Member</span>
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <!-- Members Table Card -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Nama Lengkap</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Kontak</th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Alamat</th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @forelse($approvedMembers as $member)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-slate-900">{{ $member->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-slate-900">{{ $member->email }}</div>
                                        <div class="text-xs text-slate-500">{{ $member->phone_number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal text-sm text-slate-600 max-w-xs">
                                        {{ $member->address }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex items-center justify-center gap-4">
                                            <a href="{{ route('members.edit', $member->id) }}"
                                                class="text-blue-600 hover:text-blue-800 transition" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path
                                                        d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                                    <path fill-rule="evenodd"
                                                        d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini? Tindakan ini tidak dapat dibatalkan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 transition"
                                                    title="Hapus">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-12">
                                        <div class="flex flex-col items-center justify-center text-slate-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-400 mb-4"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21v-4.5A5.25 5.25 0 0012 12h-3" />
                                            </svg>
                                            <p class="font-semibold text-lg">Belum Ada Member</p>
                                            <p class="text-sm">Saat ini tidak ada member aktif yang terdaftar.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                @if ($approvedMembers->hasPages())
                    <div class="p-6 bg-white border-t border-slate-200">
                        {{ $approvedMembers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
