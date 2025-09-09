<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Tampilkan daftar admin.
     */
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
        return view('admin.index', compact('admins'));
    }

    /**
     * Tampilkan form tambah admin.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Simpan admin baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit admin.
     */
    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    /**
     * Update admin.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admin,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    /**
     * Hapus admin.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.admin.index')->with('success', 'Admin berhasil dihapus.');
    }
}
