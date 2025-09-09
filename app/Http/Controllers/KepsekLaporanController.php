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
    $query = Laporan::with(['user', 'suratRelasi'])->latest();
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

        $laporan = $query->paginate(10);

    return view('laporan.index-kepsek', compact('laporan', 'users'));
    }
}
