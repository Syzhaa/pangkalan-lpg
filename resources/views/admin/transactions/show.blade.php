@extends('layouts.admin')
@section('header', 'Detail Transaksi')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Kode: {{ $transaction->transaction_code }}</h2>
            <a href="{{ route('transactions.print', $transaction->id) }}" target="_blank"
                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                🖨️ Cetak Struk
            </a>
        </div>

        {{-- Info Umum Transaksi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h4 class="font-bold">Pelanggan:</h4>
                <p>{{ $transaction->user->name }}</p>
            </div>
            <div>
                <h4 class="font-bold">Tanggal Transaksi:</h4>
                <p>{{ $transaction->created_at->format('d F Y, H:i') }}</p>
            </div>
            <div>
                <h4 class="font-bold">Status Pembayaran:</h4>
                <span
                    class="px-2 py-1 text-sm rounded-full {{ $transaction->payment_status == 'lunas' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                    {{ ucfirst($transaction->payment_status) }}
                </span>
            </div>
        </div>

        {{-- Tabel Rincian Barang --}}
        <h3 class="text-lg font-semibold mb-2 border-t pt-4">Rincian Barang</h3>
        <table class="min-w-full bg-white">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 text-left">Produk</th>
                    <th class="py-2 px-4 text-left">Harga Satuan</th>
                    <th class="py-2 px-4 text-center">Kuantitas</th>
                    <th class="py-2 px-4 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->details as $detail)
                    <tr class="border-b">
                        <td class="py-2 px-4">{{ $detail->product->name }}</td>
                        <td class="py-2 px-4">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                        <td class="py-2 px-4 text-center">{{ $detail->quantity }}</td>
                        <td class="py-2 px-4 text-right">Rp
                            {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="font-bold">
                <tr>
                    <td colspan="3" class="text-right py-2 px-4">Grand Total</td>
                    <td class="text-right py-2 px-4">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-6 text-right">
            <a href="{{ route('transactions.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali ke Riwayat Transaksi
            </a>
        </div>
    </div>
@endsection
