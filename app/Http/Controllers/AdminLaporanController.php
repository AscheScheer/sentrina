<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Surat;
use App\Events\LaporanUpdated;

class AdminLaporanController extends Controller
{
    /**
     * Tampilkan daftar laporan setoran untuk admin.
     */
    public function index(Request $request)
    {
        $query = Laporan::with(['user', 'suratRelasi'])->latest();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $laporan = $query->paginate(10);

        return view('laporan.index-admin', compact('laporan'));
    }

    /**
     * Tampilkan form tambah laporan untuk admin.
     */
    public function create()
    {
        $users = User::all();
        $surat = Surat::all();
        $latestLaporan = \App\Models\Laporan::with(['user', 'suratRelasi'])
            ->latest()
            ->take(10)
            ->get();
        return view('laporan.create-admin', compact('users', 'surat', 'latestLaporan'));
    }

    /**
     * Simpan laporan baru oleh admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'surat_id' => 'required|exists:surat,id',
            'ayat_halaman' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $laporan = Laporan::create([
            'user_id' => $request->user_id,
            'surat_id' => $request->surat_id,
            'ayat_halaman' => $request->ayat_halaman,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);
        event(new LaporanUpdated($laporan));
        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit laporan untuk admin.
     */
    public function edit(Laporan $laporan)
    {
        $users = User::all();
        $surat = Surat::all();
        return view('laporan.edit-admin', compact('laporan', 'users', 'surat'));
    }

    /**
     * Update laporan oleh admin.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'surat_id' => 'required|exists:surat,id',
            'ayat_halaman' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $laporan->update([
            'user_id' => $request->user_id,
            'surat_id' => $request->surat_id,
            'ayat_halaman' => $request->ayat_halaman,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Hapus laporan oleh admin.
     */
    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
