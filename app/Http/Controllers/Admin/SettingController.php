<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman form pengaturan.
     */
    public function index()
    {
        // Ambil semua settings dan ubah menjadi array (key => value) agar mudah digunakan di view
        $settings = SiteSetting::pluck('value', 'key')->all();

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Menyimpan atau mengupdate pengaturan.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'base_name' => 'nullable|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:512',
            'hero_image' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'purchase_cooldown_days' => 'required|integer|min:1',
        ]);

        // Loop dan simpan semua data yang berbasis teks
        foreach ($validatedData as $key => $value) {
            // Lewati file, karena akan dihandle terpisah
            if ($request->hasFile($key)) {
                continue;
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                // Gunakan empty string jika value null untuk konsistensi
                ['value' => $value ?? '']
            );
        }

        // Handle file upload untuk Logo
        if ($request->hasFile('logo')) {
            $this->handleFileUpload('logo', $request->file('logo'));
        }

        // Handle file upload untuk Gambar Hero
        if ($request->hasFile('hero_image')) {
            $this->handleFileUpload('hero_image', $request->file('hero_image'));
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Helper function untuk menangani proses upload file agar tersimpan di storage link.
     *
     * @param string $key Kunci untuk database (e.g., 'logo').
     * @param \Illuminate\Http\UploadedFile $file File yang diupload dari request.
     */
    private function handleFileUpload($key, $file)
    {
        // Tentukan direktori di dalam 'storage/app/public'.
        // File akan dapat diakses melalui link simbolik.
        $directory = 'settings';

        // 1. Hapus file lama jika ada.
        $oldSetting = SiteSetting::where('key', $key)->first();
        if ($oldSetting && $oldSetting->value) {
            // $oldSetting->value berisi path relatif dari file lama, contoh: 'settings/logo_123.png'
            // Gunakan disk 'public' untuk memastikan kita menghapus dari 'storage/app/public'.
            if (Storage::disk('public')->exists($oldSetting->value)) {
                Storage::disk('public')->delete($oldSetting->value);
            }
        }

        // 2. Simpan file baru dengan nama unik di disk 'public'.
        $fileName = $key . '_' . time() . '.' . $file->getClientOriginalExtension();

        // 'storeAs' akan menyimpan file di 'storage/app/public/settings'
        // dan mengembalikan path relatifnya, contoh: 'settings/logo_456.png'.
        $path = $file->storeAs($directory, $fileName, 'public');

        // 3. Update database dengan path file yang baru.
        // Path ini yang akan digunakan untuk membuat URL publik di view.
        // Contoh di Blade: <img src="{{ Storage::url($settings['logo']) }}" alt="Logo">
        // atau: <img src="{{ asset('storage/' . $settings['logo']) }}" alt="Logo">
        SiteSetting::updateOrCreate(
            ['key' => $key],
            ['value' => $path]
        );
    }
}
