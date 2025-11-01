<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjian;
use App\Models\User;
use App\Models\Kelompok;
use Illuminate\Support\Facades\Auth;

class HasilUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = HasilUjian::with(['user.kelompok', 'staff'])->latest();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter berdasarkan username
        if ($request->filled('username')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->username . '%');
            });
        }

        // Filter berdasarkan kelompok
        if ($request->filled('kelompok')) {
            $query->whereHas('user.kelompok', function($q) use ($request) {
                $q->where('nama', $request->kelompok);
            });
        }

        $hasilUjian = $query->paginate(15);
        $users = User::all();
        $kelompoks = Kelompok::all();

        return view('hasil-ujian.index', compact('hasilUjian', 'users', 'kelompoks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::with('kelompok')->get();

        // Jika admin, sertakan daftar staff untuk dipilih
        if (Auth::guard('admin')->check()) {
            $staffList = \App\Models\Staff::all();
            return view('hasil-ujian.create', compact('users', 'staffList'));
        }

        return view('hasil-ujian.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'juz' => 'required|string|max:20',
            'keterangan' => 'nullable|string|max:500',
        ];

        // Jika admin, staff_id harus dipilih
        if (Auth::guard('admin')->check()) {
            $rules['staff_id'] = 'required|exists:staff,id';
        }

        $request->validate($rules);

        // Tentukan staff_id berdasarkan role
        $staffId = null;
        if (Auth::guard('admin')->check()) {
            // Admin memilih staff dari form
            $staffId = $request->staff_id;
        } elseif (Auth::guard('staff')->check()) {
            // Staff otomatis menggunakan ID sendiri
            $staffId = Auth::guard('staff')->id();
        }

        HasilUjian::create([
            'user_id' => $request->user_id,
            'tanggal' => $request->tanggal,
            'juz' => $request->juz,
            'staff_id' => $staffId,
            'keterangan' => $request->keterangan,
        ]);

        // Redirect berdasarkan role
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.hasil-ujian.index')
                ->with('success', 'Hasil ujian berhasil disimpan.');
        } else {
            return redirect()->route('staff.hasil-ujian.index')
                ->with('success', 'Hasil ujian berhasil disimpan.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HasilUjian $hasilUjian)
    {
        $users = User::with('kelompok')->get();

        // Jika admin, sertakan daftar staff untuk dipilih
        if (Auth::guard('admin')->check()) {
            $staffList = \App\Models\Staff::all();
            return view('hasil-ujian.edit', compact('hasilUjian', 'users', 'staffList'));
        }

        return view('hasil-ujian.edit', compact('hasilUjian', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HasilUjian $hasilUjian)
    {
        // Validation rules
        $rules = [
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'nullable|date',
            'juz' => 'required|string|max:20',
            'keterangan' => 'nullable|string|max:500',
        ];

        // Jika admin, staff_id harus dipilih
        if (Auth::guard('admin')->check()) {
            $rules['staff_id'] = 'required|exists:staff,id';
        }

        $request->validate($rules);

        // Data untuk update
        $updateData = [
            'user_id' => $request->user_id,
            'juz' => $request->juz,
            'keterangan' => $request->keterangan,
        ];

        // Update tanggal hanya jika diisi
        if ($request->filled('tanggal')) {
            $updateData['tanggal'] = $request->tanggal;
        }

        // Jika admin, update staff_id juga
        if (Auth::guard('admin')->check()) {
            $updateData['staff_id'] = $request->staff_id;
        }

        $hasilUjian->update($updateData);

        // Redirect berdasarkan role
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.hasil-ujian.index')
                ->with('success', 'Hasil ujian berhasil diperbarui.');
        } else {
            return redirect()->route('staff.hasil-ujian.index')
                ->with('success', 'Hasil ujian berhasil diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HasilUjian $hasilUjian)
    {
        $hasilUjian->delete();

        return redirect()->route('staff.hasil-ujian.index')
            ->with('success', 'Hasil ujian berhasil dihapus.');
    }

    /**
     * Display hasil ujian for current user only
     */
    public function userIndex(Request $request)
    {
        $user = Auth::user();
        $query = HasilUjian::with(['staff'])->where('user_id', $user->id)->latest();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Filter berdasarkan juz
        if ($request->filled('juz')) {
            $query->where('juz', 'like', '%' . $request->juz . '%');
        }

        // Filter berdasarkan staff
        if ($request->filled('staff')) {
            $query->whereHas('staff', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->staff . '%');
            });
        }

        $hasilUjian = $query->paginate(15);

        // Data untuk filter dropdown
        $staffList = HasilUjian::with('staff')
            ->where('user_id', $user->id)
            ->get()
            ->pluck('staff.name')
            ->unique()
            ->filter()
            ->values();

        return view('hasil-ujian.user-index', compact('hasilUjian', 'staffList', 'user'));
    }
}
