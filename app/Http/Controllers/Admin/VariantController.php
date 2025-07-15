<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variant;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = Variant::latest()->paginate(10); // Ambil 10 data terbaru
        return view('admin.variants.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.variants.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255|unique:variants',
        ]);

        // 2. Buat Data
        Variant::create($request->all());

        // 3. Redirect dengan pesan sukses
        return redirect()->route('variants.index')
            ->with('success', 'Varian baru berhasil ditambahkan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Variant $variant)
    {
        return view('admin.variants.edit', compact('variant'));
    }

    public function update(Request $request, Variant $variant)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:255|unique:variants,name,' . $variant->id,
        ]);

        // 2. Update Data
        $variant->update($request->all());

        // 3. Redirect dengan pesan sukses
        return redirect()->route('variants.index')
            ->with('success', 'Varian berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Variant $variant)
    {
        $variant->delete();

        return redirect()->route('variants.index')
            ->with('success', 'Varian berhasil dihapus.');
    }
}
