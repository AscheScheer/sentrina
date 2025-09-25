<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kelompok;

class UserController extends Controller
{
    /**
     * Tampilkan daftar user.
     */
public function index(Request $request)
{
    $query = User::with('kelompok')->latest();

    // Filter berdasarkan kelompok jika ada
    if ($request->filled('kelompok_filter')) {
        if ($request->kelompok_filter === 'null') {
            $query->whereNull('kelompok_id');
        } else {
            $query->where('kelompok_id', $request->kelompok_filter);
        }
    }

    $users = $query->paginate(25);
    $kelompoks = Kelompok::all(); // Ambil semua data kelompok untuk filter

    return view('user.index', compact('users', 'kelompoks'));
}

    /**
     * Tampilkan form tambah user.
     */
    public function create()
    {
        $kelompoks = Kelompok::all(); // Ambil semua data kelompok
        return view('user.create', compact('kelompoks')); // Kirim ke view
    }


    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|unique:users,nis',
            'kelompok_id' => 'nullable|exists:kelompoks,id', // Kelompok opsional
            'password' => 'required|string|min:6|confirmed',
        ]);

        $userData = [
            'name' => $request->name,
            'nis' => $request->nis,
            'password' => bcrypt($request->password),
        ];

        // Hanya tambahkan kelompok_id jika ada nilai
        if ($request->filled('kelompok_id')) {
            $userData['kelompok_id'] = $request->kelompok_id;
        }

        User::create($userData);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function editProfile()
    {
        $user = Auth::user(); // ambil user login
        $kelompoks = Kelompok::all(); // Ambil semua data kelompok
        return view('user.profile', compact('user', 'kelompoks')); // Kirim data user dan kelompoks
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|unique:users,nis,' . $user->id, // Diubah dari email ke nis
            'kelompok_id' => 'nullable|exists:kelompoks,id',         // Kelompok opsional
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'nis' => $request->nis,                   // Diubah
        ];

        // Hanya tambahkan kelompok_id jika ada nilai
        if ($request->filled('kelompok_id')) {
            $data['kelompok_id'] = $request->kelompok_id;
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        User::where('id', $user->id)->update($data);

        // Re-authenticate user jika NIS berubah untuk menjaga session tetap aktif
        if ($request->nis !== $user->nis) {
            $updatedUser = User::find($user->id);
            Auth::login($updatedUser);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Profil berhasil diperbarui.')
            ->with('show_alert', true);
    }


    public function edit($id)
    {
        // Find user by ID with error handling
        $user = User::with('kelompok')->findOrFail($id);
        $kelompoks = Kelompok::all(); // Ambil semua data kelompok
        return view('user.edit', compact('user', 'kelompoks')); // Kirim ke view
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nis' => 'required|string|unique:users,nis,' . $user->id,
            'kelompok_id' => 'nullable|exists:kelompoks,id', // Kelompok opsional
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'nis' => $request->nis,
        ];

        // Hanya tambahkan kelompok_id jika ada nilai
        if ($request->filled('kelompok_id')) {
            $data['kelompok_id'] = $request->kelompok_id;
        }

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
