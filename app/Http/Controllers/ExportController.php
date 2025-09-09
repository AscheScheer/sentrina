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

        $data = Laporan::where('user_id', Auth::id())
            ->whereBetween('tanggal', [$start, $end])
            ->get();

        $pdf = PDF::loadView('exports.laporan_pdf', ['data' => $data, 'start' => $start, 'end' => $end]);

        return $pdf->download("laporan_tahfidz_{$start}_to_{$end}.pdf");
    }
}
