@extends('layouts.admin')
@section('header', 'Laporan Penjualan')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200 rounded-lg">

        {{-- Form Filter Tanggal --}}
        <form method="GET" action="{{ route('reports.sales') }}" class="mb-8">
            <h3 class="text-lg font-semibold mb-2">Filter Laporan</h3>
            <div class="flex flex-wrap items-end space-y-2 md:space-y-0 md:space-x-4 bg-gray-50 p-4 rounded-md">
                <div class="flex-grow">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                    <input type="date" name="start_date" id="start_date" value="{{ $startDate }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex-grow">
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Akhir</label>
                    <input type="date" name="end_date" id="end_date" value="{{ $endDate }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex space-x-2 pt-5">
                    <button type="submit"
                        class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Filter
                    </button>
                    <a href="{{ route('reports.sales.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                        class="w-full md:w-auto px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 whitespace-nowrap">
                        Export ke Excel
                    </a>
                </div>
            </div>
        </form>

        {{-- Diagram Batang Penjualan --}}
        <div class="mb-8 p-4 border rounded-lg shadow-sm">
            <h3 class="font-semibold mb-2 text-gray-800">Grafik Penjualan</h3>
            <div class="h-80"> {{-- Memberi tinggi pada container canvas --}}
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        {{-- Ringkasan Pendapatan --}}
        <div class="mb-6 p-4 bg-indigo-50 rounded-lg border border-indigo-200">
            <h3 class="text-lg font-bold text-indigo-800">Total Pendapatan
                ({{ \Carbon\Carbon::parse($startDate)->isoFormat('D MMM Y') }} -
                {{ \Carbon\Carbon::parse($endDate)->isoFormat('D MMM Y') }})</h3>
            <p class="text-3xl font-extrabold text-indigo-600 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>

        {{-- Tabel Rincian Transaksi --}}
        <h3 class="text-lg font-semibold mb-2 border-t pt-4">Rincian Transaksi</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4 text-left">Kode</th>
                        <th class="py-2 px-4 text-left">Pelanggan</th>
                        <th class="py-2 px-4 text-left">Total</th>
                        <th class="py-2 px-4 text-left">Tanggal</th>
                        <th class="py-2 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse($transactions as $transaction)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $transaction->transaction_code }}</td>
                            <td class="py-3 px-4">{{ $transaction->user->name }}</td>
                            <td class="py-3 px-4">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">{{ $transaction->created_at->isoFormat('D MMM Y, HH:mm') }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ route('transactions.show', $transaction->id) }}"
                                    class="text-blue-500 hover:underline" target="_blank">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">Tidak ada transaksi pada rentang tanggal ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{-- appends(request()->query()) akan memastikan filter tanggal tetap ada saat pindah halaman --}}
            {{ $transactions->appends(request()->query())->links() }}
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Panggil library Chart.js dari CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Ambil data dari PHP (Blade) ke JavaScript
        const chartLabels = @json($chartLabels);
        const chartData = @json($chartData);

        const ctx = document.getElementById('salesChart');

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: chartData,
                        backgroundColor: 'rgba(79, 70, 229, 0.6)', // Warna Indigo
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                // Format Angka menjadi Rupiah
                                callback: function(value, index, values) {
                                    if (parseInt(value) >= 1000) {
                                        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                                    } else {
                                        return 'Rp ' + value;
                                    }
                                }
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Sembunyikan legenda
                        }
                    }
                }
            });
        }
    </script>
@endpush
