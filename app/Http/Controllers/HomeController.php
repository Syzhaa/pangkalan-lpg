<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data yang sudah ada
        $settings = SiteSetting::pluck('value', 'key')->all();
        $products = Product::with(['variant', 'brand'])->latest()->take(8)->get();
        $testimonials = Testimonial::with('user')->where('is_visible', true)->latest()->take(3)->get();

        // --- DATA BARU UNTUK STATISTIK ---

        // 1. Persentase Kepuasan (Rating 4 & 5)
        $totalTestimonials = Testimonial::where('is_visible', true)->count();
        $satisfiedCount = Testimonial::where('is_visible', true)->whereIn('rating', [4, 5])->count();
        $satisfiedPercentage = ($totalTestimonials > 0) ? round(($satisfiedCount / $totalTestimonials) * 100) : 100;

        // 2. Rata-rata Kualitas (dari semua rating)
        $averageRating = Testimonial::where('is_visible', true)->avg('rating');
        $averageRatingFormatted = number_format($averageRating, 1);

        // 3. Jumlah Produk yang Tersedia
        $productsAvailable = Product::count();

        // Kirim semua data ke view
        return view('welcome', compact(
            'settings',
            'products',
            'testimonials',
            'satisfiedPercentage',
            'averageRatingFormatted',
            'productsAvailable'
        ));
    }
}
