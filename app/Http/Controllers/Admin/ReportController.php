<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\SalesExport; // <-- Import class export
use Maatwebsite\Excel\Facades\Excel; // <-- Import Excel facade
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // app/Http/Controllers/Admin/ReportController.php

    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // Query untuk tabel laporan
        $transactions = Transaction::with('user')
            ->whereBetween('created_at', [$start, $end])
            ->latest()
            ->paginate(20);

        $totalRevenue = Transaction::whereBetween('created_at', [$start, $end])->sum('total_amount');

        // Query dan proses data untuk diagram
        $diffInDays = $end->diffInDays($start);

        $salesDataQuery = Transaction::query()
            ->whereBetween('created_at', [$start, $end])
            ->select(DB::raw('SUM(total_amount) as total'));

        if ($diffInDays <= 31) {
            // Kelompokkan dan urutkan per HARI
            $salesDataQuery->addSelect(DB::raw('DATE(created_at) as date'))
                ->groupBy('date')
                ->orderBy('date', 'asc'); // <-- INI PERBAIKANNYA
        } else {
            // Kelompokkan dan urutkan per BULAN
            $salesDataQuery->addSelect(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"))
                ->groupBy('month')
                ->orderBy('month', 'asc'); // <-- INI PERBAIKANNYA
        }

        $salesData = $salesDataQuery->get();

        // Format data untuk Chart.js
        $chartLabels = $salesData->map(function ($item) use ($diffInDays) {
            if ($diffInDays <= 31) {
                return Carbon::parse($item->date)->format('d M');
            } else {
                return Carbon::parse($item->month . '-01')->format('M Y');
            }
        });

        $chartData = $salesData->pluck('total');

        return view('admin.reports.sales', compact(
            'transactions',
            'totalRevenue',
            'startDate',
            'endDate',
            'chartLabels',
            'chartData'
        ));
    }

    public function exportSales(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        $fileName = 'laporan-penjualan-' . $startDate . '-' . $endDate . '.xlsx';

        return Excel::download(new SalesExport($startDate, $endDate), $fileName);
    }
    public function profitAndLoss(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Ambil semua detail transaksi dalam rentang waktu yang ditentukan
        $details = TransactionDetail::with('product', 'transaction')
            ->whereHas('transaction', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
            })
            ->get();

        $totalRevenue = 0;
        $totalCogs = 0; // Cost of Goods Sold / Harga Pokok Penjualan (HPP)

        foreach ($details as $detail) {
            $totalRevenue += $detail->price * $detail->quantity;
            $totalCogs += $detail->product->purchase_price * $detail->quantity;
        }

        $netProfit = $totalRevenue - $totalCogs;

        // Ambil data transaksi untuk ditampilkan dalam tabel (opsional, tapi bagus untuk rincian)
        $transactions = Transaction::with('user')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->latest()
            ->paginate(20);

        return view('admin.reports.profit_loss', compact(
            'transactions',
            'totalRevenue',
            'totalCogs',
            'netProfit',
            'startDate',
            'endDate'
        ));
    }
}
