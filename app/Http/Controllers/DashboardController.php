<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use App\Models\Laporan;
use App\Models\HasilUjian;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get surat that the user has reported (through laporan)
        $surat = Surat::whereHas('laporanSetoran', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        $latestLaporan = Laporan::with(['user', 'suratRelasi'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // Get hafalan statistics from hasil ujian
        $hafalanStats = $this->getHafalanStatistics($user->id);

        // Get latest hasil ujian
        $latestHasilUjian = HasilUjian::with(['staff'])
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'users' => collect([$user]),
            'surat' => $surat,
            'latestLaporan' => $latestLaporan,
            'hafalanStats' => $hafalanStats,
            'latestHasilUjian' => $latestHasilUjian
        ]);
    }

    private function getHafalanStatistics($userId)
    {
        // Total juz yang sudah diuji
        $totalJuzDiuji = HasilUjian::where('user_id', $userId)
            ->distinct('juz')
            ->count('juz');

        // Total ujian yang sudah dilakukan
        $totalUjian = HasilUjian::where('user_id', $userId)->count();

        // Juz terakhir yang diuji
        $juzTerakhir = HasilUjian::where('user_id', $userId)
            ->latest('tanggal')
            ->value('juz');

        // Progress hafalan (dari 30 juz)
        $progressPercentage = ($totalJuzDiuji / 30) * 100;

        // Ujian bulan ini
        $ujianBulanIni = HasilUjian::where('user_id', $userId)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        return [
            'total_juz_diuji' => $totalJuzDiuji,
            'total_ujian' => $totalUjian,
            'juz_terakhir' => $juzTerakhir,
            'progress_percentage' => round($progressPercentage, 1),
            'ujian_bulan_ini' => $ujianBulanIni
        ];
    }
}
