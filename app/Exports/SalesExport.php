<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Transaction::query()
            ->with(['user', 'details.product'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate]);
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Pelanggan',
            'Tanggal',
            'Status',
            'Total',
            'Rincian Barang',
        ];
    }

    public function map($transaction): array
    {
        $details = $transaction->details->map(function ($detail) {
            return $detail->product->name . ' (' . $detail->quantity . 'x)';
        })->implode(', ');

        return [
            $transaction->transaction_code,
            $transaction->user->name,
            $transaction->created_at->format('d-m-Y H:i'),
            $transaction->payment_status,
            $transaction->total_amount,
            $details,
        ];
    }
}
