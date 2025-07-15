<!DOCTYPE html>
<html>

<head>
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
        }

        .container {
            width: 100%;
        }

        .header,
        .footer {
            text-align: center;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content th,
        .content td {
            padding: 2px 0;
        }

        .text-right {
            text-align: right;
        }

        hr {
            border: 0;
            border-top: 1px dashed #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h3>PANGKALAN GAS LPG</h3>
            <p>Jl. Pangeran Antasari No. 123, Banjarmasin</p>
            <hr>
        </div>
        <div class="content">
            <p>Kode: {{ $transaction->transaction_code }}</p>
            <p>Tanggal: {{ $transaction->created_at->format('d/m/Y H:i') }}</p>
            <p>Pelanggan: {{ $transaction->user->name }}</p>
            <hr>
            <table>
                <tbody>
                    @foreach ($transaction->details as $detail)
                        <tr>
                            <td colspan="2">{{ $detail->product->name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $detail->quantity }} x {{ number_format($detail->price) }}</td>
                            <td class="text-right">{{ number_format($detail->quantity * $detail->price) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr>
            <table>
                <tbody>
                    <tr>
                        <td><strong>Total</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($transaction->total_amount) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="footer">
            <hr>
            <p>Terima kasih telah berbelanja!</p>
        </div>
    </div>
</body>

</html>
