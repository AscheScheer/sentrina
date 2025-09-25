<?php

namespace Database\Factories;

use App\Models\Laporan;
use App\Models\User;
use App\Models\Surat;
use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class LaporanFactory extends Factory
{
    protected $model = Laporan::class;

    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'surat_id' => Surat::inRandomOrder()->first()?->id ?? Surat::factory(),
            'ayat_halaman' => $this->faker->bothify('Ayat ##, Halaman ##'),
            'tanggal' => $this->faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
            'keterangan' => $this->faker->optional()->sentence(),
            'juz' => $this->faker->optional(0.7)->numberBetween(1, 30), // 70% chance ada juz, 1-30
            'staff_id' => $this->faker->optional(0.8)->randomElement([
                Staff::inRandomOrder()->first()?->id,
                null // 20% chance null (laporan lama atau dari admin)
            ]),
        ];
    }
}

/*
    To create Laporan model records using this factory in Laravel Tinker, use:

    Laporan::factory()->count(5)->create();

    or for a single record:

    Laporan::factory()->create();

    To create laporan with specific staff:

    Laporan::factory()->create(['staff_id' => 1]);

    To create laporan without staff (admin created):

    Laporan::factory()->create(['staff_id' => null]);
*/
