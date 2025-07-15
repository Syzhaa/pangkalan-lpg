<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class MemberController extends Controller
{
    /**
     * Menampilkan daftar member yang menunggu persetujuan.
     */
    public function pending()
    {
        $pendingMembers = User::where('role', 'member')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);
        return view('admin.members.pending', compact('pendingMembers'));
    }

    /**
     * Menyetujui pendaftaran member.
     */
    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);
        return redirect()->route('members.pending')->with('success', 'Member berhasil disetujui.');
    }

    /**
     * Menampilkan daftar semua member yang sudah disetujui.
     */
    public function index()
    {
        $approvedMembers = User::where('role', 'member')
            ->where('status', 'approved')
            ->latest()
            ->paginate(15);
        return view('admin.members.index', compact('approvedMembers'));
    }

    /**
     * Menghapus data member.
     */
    public function destroy(User $user)
    {
        // Pastikan hanya member yang bisa dihapus lewat route ini
        if ($user->role === 'member') {
            $user->delete();
            return back()->with('success', 'Member berhasil dihapus.');
        }
        return back()->with('error', 'Tidak dapat menghapus data admin.');
    }
    // ... (method index, pending, approve yang sudah ada)

    /**
     * Menampilkan form untuk membuat member baru.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Menyimpan member baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'phone_number' => ['required', 'string', 'max:15'],
            'ktp_number' => ['required', 'string', 'max:20', 'unique:' . User::class],
            'address' => ['required', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'ktp_number' => $request->ktp_number,
            'address' => $request->address,
            'password' => Hash::make(Str::random(10)), // Tetap buat password acak
            'role' => 'member',
            'status' => 'approved',
        ]);

        return redirect()->route('members.index')->with('success', 'Member baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit member.
     */
    public function edit(User $user)
    {
        return view('admin.members.edit', compact('user'));
    }

    /**
     * Mengupdate data member di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone_number' => ['required', 'string', 'max:15'],
            'ktp_number' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'address' => ['required', 'string'],
        ]);

        // Langsung update tanpa password
        $user->update($request->all());

        return redirect()->route('members.index')->with('success', 'Data member berhasil diperbarui.');
    }
}
