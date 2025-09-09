<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kepsek;
use Illuminate\Support\Facades\Hash;

class KepsekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if kepsek already exists to prevent duplicates
        if(Kepsek::where("email","kepsek@example.com")->first()) return;

        Kepsek::create([
            'name' => 'Kepala Sekolah',
            'email' => 'kepsek@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
