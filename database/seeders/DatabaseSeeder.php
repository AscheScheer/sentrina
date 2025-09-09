<?php

namespace Database\Seeders;

use App\Models\Kepsek;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat user dummy
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

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
    }
}
