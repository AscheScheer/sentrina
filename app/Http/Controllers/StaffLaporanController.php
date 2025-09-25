<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Laporan;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\LaporanUpdated;

class StaffLaporanController extends Controller
{
    /**
     * Tampilkan daftar laporan setoran untuk staff.
     */
    public function index(Request $request)
    {
    $query = Laporan::with(['user', 'suratRelasi', 'staff'])->latest();
    $users = \App\Models\User::all();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Add username filter
        if ($request->filled('username')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->username . '%');
            });
        }

        $laporan = $query->paginate(25);

    return view('laporan.index-staff', compact('laporan', 'users'));
    }

    /**
     * Tampilkan form tambah laporan untuk staff.
     */
    public function create()
    {
        $users = User::all();
        $surat = Surat::all();
        $latestLaporan = \App\Models\Laporan::with(['user', 'suratRelasi', 'staff'])
            ->latest()
            ->take(10)
            ->get();
        return view('laporan.create-staff', compact('users', 'surat', 'latestLaporan'));
    }

    /**
     * Simpan laporan baru oleh staff.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'surat_id' => 'required|exists:surat,id',
            'ayat_halaman' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'juz' => 'nullable|string|max:255',
        ]);

        $laporan = Laporan::create([
            'user_id' => $request->user_id,
            'surat_id' => $request->surat_id,
            'ayat_halaman' => $request->ayat_halaman,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'juz' => $request->juz,
            'staff_id' => Auth::guard('staff')->id(), // Auto-fill dengan staff yang login
        ]);
        event(new LaporanUpdated($laporan));
        return redirect()->route('staff.laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit laporan untuk staff.
     */
    public function edit(Laporan $laporan)
    {
        $users = User::all();
        $surat = Surat::all();
        return view('laporan.edit-staff', compact('laporan', 'users', 'surat'));
    }

    /**
     * Update laporan oleh staff.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'surat_id' => 'required|exists:surat,id',
            'ayat_halaman' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
            'juz' => 'nullable|string|max:255',
        ]);

        $laporan->update([
            'user_id' => $request->user_id,
            'surat_id' => $request->surat_id,
            'ayat_halaman' => $request->ayat_halaman,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'juz' => $request->juz,
            // staff_id tidak diupdate karena harus tetap sesuai staff yang pertama kali input
        ]);

        return redirect()->route('staff.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Hapus laporan oleh staff.
     */
    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('staff.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
