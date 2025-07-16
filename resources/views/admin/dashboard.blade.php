{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1: Revenue -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <h4 class="font-semibold text-lg text-blue-100">Pendapatan (Bulan Ini)</h4>
                    <p class="text-4xl font-bold mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white/30 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-dollar-sign"><line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
            </div>
        </div>

        <!-- Card 2: Transactions -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <h4 class="font-semibold text-lg text-green-100">Transaksi (Bulan Ini)</h4>
                    <p class="text-4xl font-bold mt-2">{{ $totalTransactions }}</p>
                </div>
                <div class="bg-white/30 p-3 rounded-full">
                     <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-right"><path d="M8 3 4 7l4 4"/><path d="M4 7h16"/><path d="m16 21 4-4-4-4"/><path d="M20 17H4"/></svg>
                </div>
            </div>
        </div>

        <!-- Card 3: Products -->
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <h4 class="font-semibold text-lg text-yellow-100">Total Produk</h4>
                    <p class="text-4xl font-bold mt-2">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white/30 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package"><line x1="16.5" x2="7.5" y1="9.4" y2="9.4"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" x2="12" y1="22.08" y2="12"/></svg>
                </div>
            </div>
        </div>

        <!-- Card 4: Members -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-6 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start">
                <div class="flex flex-col">
                    <h4 class="font-semibold text-lg text-purple-100">Total Member</h4>
                    <p class="text-4xl font-bold mt-2">{{ $totalMembers }}</p>
                </div>
                <div class="bg-white/30 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Sales Chart --}}
    <div class="p-6 bg-white rounded-xl shadow-lg">
        <h3 class="font-bold mb-4 text-xl text-gray-800">Grafik Penjualan (12 Bulan Terakhir)</h3>
        <div style="height: 400px;">
            <canvas id="dashboardSalesChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Chart.js from CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data from Blade to JavaScript
            const chartLabels = @json($chartLabels);
            const chartData = @json($chartData);

            const ctx = document.getElementById('dashboardSalesChart').getContext('2d');

            // Gradient for the chart area
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.4)');
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

            new Chart(ctx, {
                type: 'line', // Changed to line chart for better trend visualization
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Total Penjualan (Rp)',
                        data: chartData,
                        backgroundColor: gradient, // Use gradient for area fill
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 3,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: 'rgba(59, 130, 246, 1)',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true, // Fill the area under the line
                        tension: 0.4 // Makes the line curved
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb', // Lighter grid lines
                                borderDash: [2, 4],
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                // Format ticks as Indonesian Rupiah
                                callback: function(value, index, values) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false // Hide vertical grid lines
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 12,
                                    weight: '500'
                                 }
                            }
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hiding legend for a cleaner look
                        },
                        tooltip: {
                            backgroundColor: '#1f2937',
                            titleColor: '#f9fafb',
                            bodyColor: '#d1d5db',
                            titleFont: { size: 14, weight: 'bold' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false, // Hide the color box in tooltip
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index',
                    }
                }
            });
        });
    </script>
@endpush
