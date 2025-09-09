<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $surat = Surat::where('user_id', $user->id)->get();
        $latestLaporan = Laporan::with(['user', 'suratRelasi'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'users' => collect([$user]),
            'surat' => $surat,
            'latestLaporan' => $latestLaporan
        ]);
    }

}
