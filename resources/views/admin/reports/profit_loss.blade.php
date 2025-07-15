@extends('layouts.admin')
@section('header', 'Laporan Laba Rugi')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        {{-- Form Filter Tanggal --}}
        <form method="GET" action="{{ route('reports.profit_loss') }}" class="mb-6">
            <div class="flex items-end space-x-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Filter</button>
            </div>
        </form>

        {{-- Ringkasan Laba Rugi --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="p-4 bg-blue-100 rounded-lg">
                <h4 class="font-bold text-blue-800">Total Pendapatan</h4>
                <p class="text-2xl">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-red-100 rounded-lg">
                <h4 class="font-bold text-red-800">Total Modal (HPP)</h4>
                <p class="text-2xl">Rp {{ number_format($totalCogs, 0, ',', '.') }}</p>
            </div>
            <div class="p-4 bg-green-100 rounded-lg">
                <h4 class="font-bold text-green-800">Laba Bersih</h4>
                <p class="text-2xl">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Tabel Rincian Transaksi --}}
        <h3 class="text-lg font-semibold mb-2 border-t pt-4">Rincian Transaksi</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Kode</th>
                        <th class="py-2 px-4 text-left">Pelanggan</th>
                        <th class="py-2 px-4 text-left">Total Penjualan</th>
                        <th class="py-2 px-4 text-left">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($transactions as $transaction)
                        <tr class="border-b">
                            <td class="py-2 px-4">{{ $transaction->transaction_code }}</td>
                            <td class="py-2 px-4">{{ $transaction->user->name }}</td>
                            <td class="py-2 px-4">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td class="py-2 px-4">{{ $transaction->created_at->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Tidak ada transaksi pada rentang tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $transactions->appends(request()->query())->links() }}</div>
    </div>
@endsection
