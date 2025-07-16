<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // <-- Import DB Facade
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SiteSetting;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar transaksi.
     */
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(15);
        return view('admin.transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan form untuk membuat transaksi baru.
     */
    public function create()
    {
        // Ambil pelanggan (member) dan produk yang stoknya ada
        $customers = User::where('role', 'member')->where('status', 'approved')->get();
        $products = Product::where('stock', '>', 0)->get();

        // Buat array json untuk digunakan di Alpine.js
        $productsJson = $products->mapWithKeys(function ($product) {
            return [
                $product->id => [
                    'name' => $product->name,
                    'price' => $product->selling_price,
                    'stock' => $product->stock,
                    'is_restricted' => $product->is_restricted
                ]
            ];
        });

        return view('admin.transactions.create', compact('customers', 'products', 'productsJson'));
    }


    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        // 1. Validasi (tambahkan payment_status)
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'payment_status' => 'required|in:lunas,belum_lunas', // <-- Tambahan
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        $cart = $request->input('cart');
        $grandTotal = 0;
        $productsToUpdate = [];

        // 2. Cek stok dan hitung total
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product->stock < $item['quantity']) {
                return back()->withInput()->withErrors(['cart' => 'Stok produk ' . $product->name . ' tidak mencukupi.']);
            }
            $grandTotal += $product->selling_price * $item['quantity'];
            $productsToUpdate[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
            ];
        }

        try {
            // 3. Gunakan DB Transaction
            DB::transaction(function () use ($request, $grandTotal, $productsToUpdate) {
                // Buat transaksi utama
                $transaction = Transaction::create([
                    'user_id' => $request->user_id,
                    'transaction_code' => 'TRX-' . time(),
                    'total_amount' => $grandTotal,
                    'payment_status' => $request->payment_status, // <-- Ambil dari request
                ]);

                // Simpan detail transaksi dan kurangi stok
                foreach ($productsToUpdate as $item) {
                    $transaction->details()->create([
                        'product_id' => $item['product']->id,
                        'quantity' => $item['quantity'],
                        'price' => $item['product']->selling_price,
                    ]);
                    $item['product']->decrement('stock', $item['quantity']);
                }
            });
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['cart' => 'Terjadi kesalahan saat menyimpan transaksi. ' . $e->getMessage()]);
        }

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil disimpan.');
    }
    public function show(Transaction $transaction)
    {
        // Load relasi yang dibutuhkan: user dan detail beserta produk di dalamnya
        $transaction->load(['user', 'details.product']);

        return view('admin.transactions.show', compact('transaction'));
    }
    public function print(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product']);

        // Buat PDF dari view 'admin.transactions.receipt'
        $pdf = PDF::loadView('admin.transactions.receipt', compact('transaction'));

        // Atur ukuran kertas agar seperti struk kasir (misal: lebar 80mm)
        $pdf->setPaper([0, 0, 226.77, 841.89], 'portrait'); // Ukuran 80mm

        // Tampilkan PDF di browser
        return $pdf->stream('struk-' . $transaction->transaction_code . '.pdf');
    }
    public function updateStatus(Request $request, Transaction $transaction)
    {
        $request->validate([
            'payment_status' => 'required|in:lunas,belum_lunas',
        ]);

        $transaction->update([
            'payment_status' => $request->payment_status,
        ]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
    // app/Http/Controllers/Admin/TransactionController.php

    public function checkEligibility(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::find($request->product_id);

        if (!$product->is_restricted) {
            return response()->json(['eligible' => true]);
        }

        // --- PERUBAHAN DI SINI ---
        // Ambil nilai jangka waktu dari database, jika tidak ada, default-nya 30 hari.
        $cooldownDays = SiteSetting::where('key', 'purchase_cooldown_days')->first()->value ?? 30;

        // Hitung tanggal batas berdasarkan pengaturan
        $cooldownPeriod = now()->subDays($cooldownDays);
        // -------------------------

        $hasPurchased = Transaction::where('user_id', $request->user_id)
            ->where('created_at', '>=', $cooldownPeriod) // Gunakan variabel baru
            ->whereHas('details', function ($query) use ($request) {
                $query->where('product_id', $request->product_id);
            })
            ->exists();

        if ($hasPurchased) {
            return response()->json([
                'eligible' => false,
                'message' => 'Gagal: Member ini sudah membeli produk yang sama dalam ' . $cooldownDays . ' hari terakhir.'
            ]);
        }

        return response()->json(['eligible' => true]);
    }
}
