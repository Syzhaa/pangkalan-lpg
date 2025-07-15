<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('user')->latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $members = User::where('role', 'member')->where('status', 'approved')->get();
        return view('admin.testimonials.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_job' => 'nullable|string|max:255',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $input = $request->except('is_visible');
        $input['is_visible'] = $request->has('is_visible');

        if ($image = $request->file('customer_image')) {
            // Simpan ke storage/app/public/testimonials
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path = $image->storeAs('testimonials', $imageName, 'public');

            // Simpan path relatif ke database
            $input['customer_image'] = 'testimonials/' . $imageName;
        }

        Testimonial::create($input);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    public function edit(Testimonial $testimonial)
    {
        $members = User::where('role', 'member')->where('status', 'approved')->get();
        return view('admin.testimonials.edit', compact('testimonial', 'members'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'customer_job' => 'nullable|string|max:255',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'customer_image' => 'nullable|image|mimes:jpeg,png,jpg|max:1024',
        ]);

        $input = $request->except('is_visible');
        $input['is_visible'] = $request->has('is_visible');

        if ($image = $request->file('customer_image')) {
            // Hapus gambar lama jika ada
            if ($testimonial->customer_image && Storage::disk('public')->exists($testimonial->customer_image)) {
                Storage::disk('public')->delete($testimonial->customer_image);
            }

            // Simpan gambar baru
            $imageName = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $path = $image->storeAs('testimonials', $imageName, 'public');
            $input['customer_image'] = 'testimonials/' . $imageName;
        }

        $testimonial->update($input);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimoni berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        // Hapus gambar dari storage
        if ($testimonial->customer_image && Storage::disk('public')->exists($testimonial->customer_image)) {
            Storage::disk('public')->delete($testimonial->customer_image);
        }

        $testimonial->delete();

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimoni berhasil dihapus.');
    }
}
