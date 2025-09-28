<?php

namespace App\Http\Controllers;

use App\Imports\StaffImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StaffImportController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        Excel::import(new StaffImport, $request->file('file'));

        return back()->with('success', 'Data staff berhasil diimport!');
    }
}
