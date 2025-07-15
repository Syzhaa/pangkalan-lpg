<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberRegistrationController extends Controller
{
    // Menampilkan form pendaftaran
    public function create()
    {
        return view('member.register');
    }

    // Menyimpan data pendaftar
    public function store(Request $request)
    {
        // 1. Validasi (tanpa password)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:15'],
            'ktp_number' => ['required', 'string', 'max:20', 'unique:' . User::class],
            'address' => ['required', 'string'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
        ]);

        // 2. Buat user dengan password acak
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'ktp_number' => $request->ktp_number,
            'address' => $request->address,
            'password' => Hash::make(Str::random(10)), // Buat password acak karena kolomnya wajib diisi
            // 'role' dan 'status' akan terisi nilai default dari migrasi
        ]);

        // 3. Kembalikan ke halaman yang sama dengan pesan sukses
        return redirect()->route('member.register')
            ->with('success', 'Pendaftaran berhasil! Data Anda akan segera diproses oleh admin.');
    }
}
