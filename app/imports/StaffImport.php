<?php

namespace App\Imports;

use App\Models\Staff;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Staff([
            'name'     => $row['name'],     // kolom Excel header: name
            'email'    => $row['email'],    // kolom Excel header: email
            'password' => Hash::make($row['password']), // kolom Excel header: password
        ]);
    }
}
