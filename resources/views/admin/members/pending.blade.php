@extends('layouts.admin')
@section('header', 'Persetujuan Member Baru')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Nama</th>
                        <th class="py-2 px-4 text-left">Email & No. HP</th>
                        <th class="py-2 px-4 text-left">No. KTP</th>
                        <th class="py-2 px-4 text-left">Tanggal Daftar</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($pendingMembers as $member)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $member->name }}</td>
                            <td class="py-2 px-4">
                                <div>{{ $member->email }}</div>
                                <div class="text-xs text-gray-500">{{ $member->phone_number }}</div>
                            </td>
                            <td class="py-2 px-4">{{ $member->ktp_number }}</td>
                            <td class="py-2 px-4">{{ $member->created_at->format('d M Y') }}</td>
                            <td class="py-2 px-4">
                                <form action="{{ route('members.approve', $member->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="px-3 py-1 bg-green-500 text-white text-xs rounded-full hover:bg-green-600">Setujui</button>
                                </form>
                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menolak dan menghapus pendaftar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500 text-white text-xs rounded-full hover:bg-red-600 ml-1">Tolak</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada pendaftar baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $pendingMembers->links() }}</div>
    </div>
@endsection
