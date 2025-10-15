<?php

namespace Database\Seeders;

use App\Models\Kepsek;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Kelompok;
use Database\Seeders\SuratSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\KepsekSeeder;
use Database\Seeders\HasilUjianSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat beberapa kelompok dummy terlebih dahulu
        $kelompokA = Kelompok::create(['nama' => 'Kelompok A']);
        Kelompok::create(['nama' => 'Kelompok B']);

        // 2. Buat user dummy dan hubungkan ke Kelompok A
        User::factory()->create([
            'name' => 'Test User',
            'nis' => '12345678', // Ganti email dengan nis
            'kelompok_id' => $kelompokA->id, // Hubungkan dengan id kelompok yang sudah dibuat
            'password' => bcrypt('password'), // password
        ]);

        // Opsional: Jika ingin membuat lebih banyak user dummy dengan kelompok acak
        // Pastikan Anda sudah menjalankan KelompokSeeder atau membuat kelompok seperti di atas
        // User::factory(10)->create();

        // Jalankan seeder surat
        $this->call([
            SuratSeeder::class,
        ]);

        $this->call([
            AdminSeeder::class,
        ]);

        $this->call([
            KepsekSeeder::class,
        ]);

        $this->call([
            HasilUjianSeeder::class,
        ]);
    }
}
