@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
    {{-- Kartu Ringkasan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold">Pendapatan (Bulan Ini)</h4>
            <p class="text-3xl mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold">Transaksi (Bulan Ini)</h4>
            <p class="text-3xl mt-2">{{ $totalTransactions }}</p>
        </div>
        <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold">Total Produk</h4>
            <p class="text-3xl mt-2">{{ $totalProducts }}</p>
        </div>
        <div class="bg-purple-500 text-white p-6 rounded-lg shadow-lg">
            <h4 class="font-bold">Total Member</h4>
            <p class="text-3xl mt-2">{{ $totalMembers }}</p>
        </div>
    </div>

    {{-- Grafik Penjualan --}}
    <div class="p-6 bg-white border-b border-gray-200 rounded-lg shadow-lg">
        <h3 class="font-semibold mb-4 text-xl">Grafik Penjualan (12 Bulan Terakhir)</h3>
        <div class="h-80">
            <canvas id="dashboardSalesChart"></canvas>
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

        const ctx = document.getElementById('dashboardSalesChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: chartData,
                    backgroundColor: 'rgba(59, 130, 246, 0.5)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endpush
