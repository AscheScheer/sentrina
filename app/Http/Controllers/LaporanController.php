<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Laporan;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Tampilkan daftar laporan setoran.
     */
    public function index(Request $request)
    {

        $query = Laporan::with(['user', 'suratRelasi', 'staff'])
            ->where('user_id', Auth::user()->id) // hanya laporan milik user login
            ->latest();

        // Jika ada filter tanggal dari request
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $laporan = $query->paginate(10);

        return view('laporan.index', compact('laporan'));
    }

    /**
     * Tampilkan form tambah laporan.
     */
    public function create()
    {
        $users = User::all();
        $surat = Surat::all();
        return view('laporan.create', compact('users', 'surat'));
    }

    /**
     * Simpan laporan baru.
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

        Laporan::create([
            'user_id' => $request->user_id,
            'surat' => $request->surat_id, // jika pakai FK ke tabel surat
            'ayat_halaman' => $request->ayat_halaman,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit laporan.
     */
    public function edit(Laporan $laporan)
    {
        $users = User::all();
        $surat = Surat::all();
        return view('laporan.edit', compact('laporan', 'users', 'surat'));
    }

    /**
     * Update laporan.
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
            'surat' => $request->surat_id,
            'ayat_halaman' => $request->ayat_halaman,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui.');
    }

    /**
     * Hapus laporan.
     */
    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
