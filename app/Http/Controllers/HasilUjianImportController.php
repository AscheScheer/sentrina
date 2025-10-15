<?php

namespace App\Http\Controllers;

use App\Imports\HasilUjianImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class HasilUjianImportController extends Controller
{
    public function import(Request $request)
    {
        $rules = [
            'file' => 'required|mimes:xlsx,csv,xls|max:2048'
        ];

        // Jika admin, staff_id harus dipilih
        if (Auth::guard('admin')->check()) {
            $rules['staff_id'] = 'required|exists:staff,id';
        }

        $request->validate($rules);

        try {
            // Tentukan staff_id untuk import
            $staffId = null;
            if (Auth::guard('admin')->check()) {
                $staffId = $request->staff_id;
            } elseif (Auth::guard('staff')->check()) {
                $staffId = Auth::guard('staff')->id();
            }

            Excel::import(new HasilUjianImport($staffId), $request->file('file'));

            return back()->with('success', 'Data hasil ujian berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $filePath = public_path('template_hasil_ujian.xlsx');

        if (file_exists($filePath)) {
            return response()->download($filePath, 'template_hasil_ujian.xlsx');
        }

        return back()->with('error', 'Template file tidak ditemukan.');
    }
}
