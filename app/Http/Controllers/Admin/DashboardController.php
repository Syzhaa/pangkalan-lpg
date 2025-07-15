<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Kartu Ringkasan
        $totalRevenue = Transaction::whereMonth('created_at', now()->month)->sum('total_amount');
        $totalTransactions = Transaction::whereMonth('created_at', now()->month)->count();
        $totalProducts = Product::count();
        $totalMembers = User::where('role', 'member')->count();

        // Data untuk Grafik Penjualan 12 Bulan Terakhir
        $salesData = Transaction::query()
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw("SUM(total_amount) as total")
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // Siapkan data untuk Chart.js, pastikan ada data untuk semua 12 bulan
        $chartLabels = [];
        $chartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $monthKey = $month->format('Y-m');
            $chartLabels[] = $month->format('M Y');

            $sale = $salesData->firstWhere('month', $monthKey);
            $chartData[] = $sale ? $sale->total : 0;
        }

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalTransactions',
            'totalProducts',
            'totalMembers',
            'chartLabels',
            'chartData'
        ));
    }
}
