<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Surat;
use App\Events\LaporanUpdated;

class KepsekLaporanController extends Controller
{
    /**
     * Tampilkan daftar laporan setoran untuk kepsek.
     */
    public function index(Request $request)
    {
    $query = Laporan::with(['user.kelompok', 'suratRelasi', 'staff'])->latest();
    $users = \App\Models\User::all();
    $kelompoks = \App\Models\Kelompok::all();

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Add username filter
        if ($request->filled('username')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->username . '%');
            });
        }

        // Add kelompok filter
        if ($request->filled('kelompok')) {
            $query->whereHas('user.kelompok', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->kelompok . '%');
            });
        }

        $laporan = $query->paginate(25);

    return view('laporan.index-kepsek', compact('laporan', 'users', 'kelompoks'));
    }
}
