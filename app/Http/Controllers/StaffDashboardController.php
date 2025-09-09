<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $users = \App\Models\User::all();
        $surat = \App\Models\Surat::all();
        $latestLaporan = \App\Models\Laporan::with(['user', 'suratRelasi'])
            ->latest()
            ->take(10)
            ->get();

        return view('staff-dashboard', compact('users', 'surat', 'latestLaporan'));
    }
    
}
