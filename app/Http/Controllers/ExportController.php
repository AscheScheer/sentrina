<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Laporan;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportPdf(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $username = $request->input('username');
        $kelompok = $request->input('kelompok');

        $query = Laporan::with(['user.kelompok', 'suratRelasi', 'staff']);

        // Filter by current user if it's not admin/staff export
        if (Auth::guard('web')->check()) {
            $query->where('user_id', Auth::id());
        }

        // Date range filter
        if ($start && $end) {
            $query->whereBetween('tanggal', [$start, $end]);
        }

        // Username filter
        if ($username) {
            $query->whereHas('user', function($q) use ($username) {
                $q->where('name', 'like', '%' . $username . '%');
            });
        }

        // Kelompok filter
        if ($kelompok) {
            $query->whereHas('user.kelompok', function($q) use ($kelompok) {
                $q->where('nama', $kelompok);
            });
        }

        $data = $query->orderBy('tanggal', 'desc')->get();

        $pdf = PDF::loadView('exports.laporan_pdf', [
            'data' => $data,
            'start' => $start,
            'end' => $end,
            'username' => $username,
            'kelompok' => $kelompok
        ]);

        $filename = "laporan_tahfidz";
        if ($start && $end) {
            $filename .= "_{$start}_to_{$end}";
        }
        if ($username) {
            $filename .= "_" . str_replace(' ', '_', $username);
        }
        if ($kelompok) {
            $filename .= "_" . str_replace(' ', '_', $kelompok);
        }

        return $pdf->download("{$filename}.pdf");
    }
}
