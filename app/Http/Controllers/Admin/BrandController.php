<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand; // Import model Brand
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Menampilkan daftar merek.
     */
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Menampilkan form untuk membuat merek baru.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Menyimpan merek baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands',
        ]);

        Brand::create($request->all());

        return redirect()->route('brands.index')
            ->with('success', 'Merek baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit merek.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Mengupdate merek di database.
     */
    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
        ]);

        $brand->update($request->all());

        return redirect()->route('brands.index')
            ->with('success', 'Merek berhasil diperbarui.');
    }

    /**
     * Menghapus merek dari database.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();

        return redirect()->route('brands.index')
            ->with('success', 'Merek berhasil dihapus.');
    }
}
