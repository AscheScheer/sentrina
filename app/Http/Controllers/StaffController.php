<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Tampilkan daftar staff.
     */
    public function index()
    {
        $staffs = Staff::latest()->paginate(10);
        return view('staff.index', compact('staffs'));
    }

    /**
     * Tampilkan form tambah staff.
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Simpan staff baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Staff::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit staff.
     */
    public function edit(Staff $staff)
    {
        return view('staff.edit', compact('staff'));
    }
    /**
     * Tampilkan form edit profile staff.
     */
    public function editProfile()
    {
        $staff = auth()->guard('staff')->user(); // ambil staff login
        return view('staff.profile', ['user' => $staff]);
    }

    public function updateProfile(Request $request)
    {
        $staff = auth()->guard('staff')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        Staff::where('id', $staff->id)->update($data);

        return redirect()->route('staff.dashboard')
            ->with('success', 'Profil berhasil diperbarui.')
            ->with('show_alert', true);
    }
    /**
     * Update staff.
     */
    public function update(Request $request, Staff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $staff->update($data);

        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil diperbarui.');
    }

    /**
     * Hapus staff.
     */
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff berhasil dihapus.');
    }
}
