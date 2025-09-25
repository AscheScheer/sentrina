<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Kelompok;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Siapkan data user
        $userData = [
            'name'     => $row['name'],
            'nis'      => $row['nis'],
            'password' => Hash::make($row['password']),
        ];

        // Hanya tambahkan kelompok_id jika ada nilai kelompok di Excel
        if (!empty($row['kelompok'])) {
            // Normalisasi nama kelompok (huruf kecil semua untuk pencarian)
            $namaKelompok = trim($row['kelompok']);

            // Cari kelompok berdasarkan nama (case insensitive)
            $kelompok = Kelompok::whereRaw('LOWER(nama) = ?', [strtolower($namaKelompok)])
                ->first();

            // Jika tidak ditemukan, buat kelompok baru dengan nama asli (dengan kapitalisasi)
            if (!$kelompok) {
                $kelompok = Kelompok::create(['nama' => $namaKelompok]);
            }

            $userData['kelompok_id'] = $kelompok->id;
        }

        return new User($userData);
    }
}
