<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HasilUjian;
use App\Models\User;
use App\Models\Staff;
use Carbon\Carbon;

class HasilUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $staffs = Staff::all();

        if ($users->count() > 0 && $staffs->count() > 0) {
            // Buat beberapa hasil ujian dummy
            $hasilUjianData = [];

            foreach ($users->take(10) as $user) {
                // Setiap user bisa punya beberapa hasil ujian
                $jumlahUjian = rand(2, 5);

                for ($i = 1; $i <= $jumlahUjian; $i++) {
                    $hasilUjianData[] = [
                        'user_id' => $user->id,
                        'tanggal' => Carbon::now()->subDays(rand(1, 30))->format('Y-m-d'),
                        'juz' => 'Juz ' . $i,
                        'staff_id' => $staffs->random()->id,
                        'keterangan' => $this->getRandomKeterangan(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            HasilUjian::insert($hasilUjianData);

            $this->command->info('HasilUjian seeded successfully!');
        } else {
            $this->command->warn('No users or staff found. Please seed users and staff first.');
        }
    }

    private function getRandomKeterangan()
    {
        $keteranganList = [
            'Lancar',
            'Perlu latihan lebih',
            'Sangat baik',
            'Cukup baik',
            'Masih ada kesalahan kecil',
            'Sempurna',
            'Perlu perbaikan tajwid',
            'Hafalan kuat',
            null, // beberapa tanpa keterangan
        ];

        return $keteranganList[array_rand($keteranganList)];
    }
}
