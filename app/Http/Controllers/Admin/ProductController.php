<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['variant', 'brand'])->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $variants = Variant::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('variants', 'brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'variant_id' => 'required|exists:variants,id',
            'brand_id' => 'required|exists:brands,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $input['is_restricted'] = $request->has('is_restricted');

        if ($image = $request->file('image')) {
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $imageName, 'public');
            $input['image'] = 'products/' . $imageName;
        }

        Product::create($input);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }


    public function edit(Product $product)
    {
        $variants = Variant::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'variants', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'variant_id' => 'required|exists:variants,id',
            'brand_id' => 'required|exists:brands,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $input = $request->all();
        $input['is_restricted'] = $request->has('is_restricted');

        if ($image = $request->file('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path = $image->storeAs('products', $imageName, 'public');
            $input['image'] = 'products/' . $imageName;
        } else {
            unset($input['image']);
        }

        $product->update($input);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        // Hapus gambar dari storage
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
