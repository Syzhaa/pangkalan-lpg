@extends('layouts.admin')
@section('header', 'Buat Transaksi Baru')

@section('content')
    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <div class="p-6 bg-white border-b border-gray-200" x-data="transactionForm()">
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="user_id" class="block font-medium text-sm text-gray-700">Pilih Pelanggan</label>
                    <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->phone_number }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="payment_status" class="block font-medium text-sm text-gray-700">Status Pembayaran</label>
                    <select name="payment_status" id="payment_status" class="mt-1 block w-full rounded-md" required>
                        <option value="lunas">Lunas</option>
                        <option value="belum_lunas">Belum Lunas</option>
                    </select>
                </div>
                <div>
                    <label for="product_select" class="block font-medium text-sm text-gray-700">Pilih Produk</label>
                    <div class="flex">
                        <select id="product_select" x-model="selectedProductId" class="mt-1 block w-full rounded-md">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} (Stok: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>

                        <button @click.prevent="addToCart()" type="button"
                            class="ml-2 mt-1 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Tambah</button>
                    </div>
                </div>
            </div>

            <h3 class="text-lg font-semibold mb-2">Keranjang Belanja</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-2 px-4 text-left">Produk</th>
                            <th class="py-2 px-4 text-left">Harga</th>
                            <th class="py-2 px-4 text-left w-32">Kuantitas</th>
                            <th class="py-2 px-4 text-left">Subtotal</th>
                            <th class="py-2 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in cart" :key="index">
                            <tr>
                                <td class="py-2 px-4 border-b" x-text="item.name"></td>
                                <td class="py-2 px-4 border-b" x-text="formatCurrency(item.price)"></td>
                                <td class="py-2 px-4 border-b">
                                    <input type="number" x-model.number="item.quantity" @input="updateSubtotal(index)"
                                        class="w-24 text-center rounded-md" min="1" :max="item.maxStock">
                                </td>
                                <td class="py-2 px-4 border-b" x-text="formatCurrency(item.subtotal)"></td>
                                <td class="py-2 px-4 border-b text-center">
                                    <button @click.prevent="removeFromCart(index)" type="button"
                                        class="text-red-500 hover:text-red-700">Hapus</button>
                                    <input type="hidden" :name="`cart[${index}][id]`" :value="item.id">
                                    <input type="hidden" :name="`cart[${index}][quantity]`" :value="item.quantity">
                                </td>
                            </tr>
                        </template>
                        <tr x-show="cart.length === 0">
                            <td colspan="5" class="text-center py-4">Keranjang kosong.</td>
                        </tr>
                    </tbody>
                    <tfoot class="font-bold">
                        <tr>
                            <td colspan="3" class="text-right py-2 px-4">Grand Total</td>
                            <td colspan="2" class="py-2 px-4" x-text="formatCurrency(grandTotal)"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex items-center justify-end mt-6">
                <button type="submit" class="px-6 py-3 bg-green-500 text-white rounded-md hover:bg-green-600 text-lg">
                    Simpan Transaksi
                </button>
            </div>
        </div>
    </form>

    <script>
        function transactionForm() {
            // Fixed JSON conversion syntax
            const productsData = @json($productsJson);


            return {
                selectedProductId: '',
                cart: [],
                grandTotal: 0,

                addToCart() {
                    if (!this.selectedProductId) return;

                    const product = productsData[this.selectedProductId];
                    const existingItem = this.cart.find(item => item.id == this.selectedProductId);

                    if (existingItem) {
                        if (existingItem.quantity < existingItem.maxStock) {
                            existingItem.quantity++;
                            existingItem.subtotal = existingItem.price * existingItem.quantity;
                        }
                    } else {
                        this.cart.push({
                            id: this.selectedProductId,
                            name: product.name,
                            price: product.price,
                            quantity: 1,
                            subtotal: product.price,
                            maxStock: product.stock
                        });
                    }
                    this.calculateGrandTotal();
                    this.selectedProductId = '';
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                    this.calculateGrandTotal();
                },

                updateSubtotal(index) {
                    let item = this.cart[index];
                    if (item.quantity > item.maxStock) {
                        item.quantity = item.maxStock;
                    } else if (item.quantity < 1) {
                        item.quantity = 1;
                    }
                    item.subtotal = item.price * item.quantity;
                    this.calculateGrandTotal();
                },

                calculateGrandTotal() {
                    this.grandTotal = this.cart.reduce((total, item) => total + item.subtotal, 0);
                },

                formatCurrency(amount) {
                    return 'Rp ' + amount.toLocaleString('id-ID');
                }
            }
        }
    </script>
@endsection
