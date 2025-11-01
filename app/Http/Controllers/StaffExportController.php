<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use App\Models\User;
use App\Models\Kelompok;


class StaffExportController extends Controller
{
    /**
     * Tampilkan form export laporan untuk staff.
     */
    public function exportForm()
    {
        $users = User::all();
        $kelompoks = Kelompok::all();
        
        return view('laporan.export-form', compact('users', 'kelompoks'));
    }

    /**
     * Export laporan ke PDF berdasarkan filter yang dipilih.
     */
    public function exportPdf(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $username = $request->input('username');
        $kelompok = $request->input('kelompok');

        // Build query with filters
        $query = Laporan::with(['user.kelompok', 'suratRelasi', 'staff'])
                        ->whereBetween('tanggal', [$start, $end]);

        // Add username filter if provided
        if ($username) {
            $query->whereHas('user', function ($q) use ($username) {
                $q->where('name', 'like', '%' . $username . '%');
            });
        }

        // Add kelompok filter if provided
        if ($kelompok) {
            $query->whereHas('user.kelompok', function ($q) use ($kelompok) {
                $q->where('nama', 'like', '%' . $kelompok . '%');
            });
        }

        $data = $query->latest()->get();

        $pdf = PDF::loadView('exports.laporan_pdf', [
            'data' => $data, 
            'start' => $start, 
            'end' => $end,
            'username' => $username,
            'kelompok' => $kelompok
        ]);

        // Generate filename with filters
        $filename = "laporan_tahfidz_{$start}_to_{$end}";
        if ($username) {
            $filename .= "_" . str_replace(' ', '_', $username);
        }
        if ($kelompok) {
            $filename .= "_" . str_replace(' ', '_', $kelompok);
        }
        $filename .= ".pdf";

        return $pdf->download($filename);
    }
}
