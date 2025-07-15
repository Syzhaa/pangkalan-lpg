@extends('layouts.admin')
@section('header', 'Riwayat Transaksi')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-end mb-4">
            <a href="{{ route('transactions.create') }}"
                class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">+ Buat Transaksi</a>
        </div>
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">{{ session('success') }}</div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Kode Transaksi</th>
                        <th class="py-2 px-4 text-left">Pelanggan</th>
                        <th class="py-2 px-4 text-left">Total</th>
                        <th class="py-2 px-4 text-left">Status</th>
                        <th class="py-2 px-4 text-left">Tanggal</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $transaction->transaction_code }}</td>
                            <td class="py-2 px-4">{{ $transaction->user->name }}</td>
                            <td class="py-2 px-4">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td class="py-2 px-4">
                                <span
                                    class="px-2 py-1 text-xs font-semibold rounded-full {{ $transaction->payment_status == 'lunas' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </td>
                            <td class="py-2 px-4">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('transactions.show', $transaction->id) }}"
                                    class="text-blue-500 hover:text-blue-700">Detail</a>

                                {{-- Tombol Aksi untuk Status --}}
                                @if ($transaction->payment_status == 'belum_lunas')
                                    <form action="{{ route('transactions.update_status', $transaction->id) }}"
                                        method="POST" class="inline ml-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="payment_status" value="lunas">
                                        <button type="submit" class="text-green-500 hover:text-green-700">Tandai
                                            Lunas</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $transactions->links() }}</div>
    </div>
@endsection
