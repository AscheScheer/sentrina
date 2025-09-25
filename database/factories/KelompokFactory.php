<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Kelompok;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelompok>
 */
class KelompokFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $kelompokNames = [
            'Kelas A',
            'Kelas B',
            'Kelas C',
            'Kelas D',
            'Kelas E',
            'Grup Alpha',
            'Grup Beta',
            'Grup Gamma',
            'Grup Delta',
            'Tim Merah',
            'Tim Biru',
            'Tim Hijau',
            'Tim Kuning',
            'Kelompok Tahfidz',
            'Kelompok Qiroah',
            'Kelompok Hadits',
            'Kelompok Fiqh',
            'Angkatan 2023',
            'Angkatan 2024',
            'Angkatan 2025'
        ];

        return [
            'nama' => $this->faker->unique()->randomElement($kelompokNames),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Create kelompok with specific name
     */
    public function withName(string $name): static
    {
        return $this->state(fn (array $attributes) => [
            'nama' => $name,
        ]);
    }

    /**
     * Create kelompok for specific class level
     */
    public function forClass(string $className): static
    {
        return $this->state(fn (array $attributes) => [
            'nama' => "Kelas {$className}",
        ]);
    }

    /**
     * Create kelompok for tahfidz groups
     */
    public function tahfidz(): static
    {
        $tahfidzGroups = [
            'Tahfidz Juz 1-5',
            'Tahfidz Juz 6-10',
            'Tahfidz Juz 11-15',
            'Tahfidz Juz 16-20',
            'Tahfidz Juz 21-25',
            'Tahfidz Juz 26-30',
            'Tahfidz Pemula',
            'Tahfidz Menengah',
            'Tahfidz Lanjutan'
        ];

        return $this->state(fn (array $attributes) => [
            'nama' => $this->faker->randomElement($tahfidzGroups),
        ]);
    }
}

/*
    Laravel Tinker Commands untuk KelompokFactory:

    // Buat 1 kelompok
    Kelompok::factory()->create();

    // Buat 5 kelompok
    Kelompok::factory()->count(5)->create();

    // Buat kelompok dengan nama tertentu
    Kelompok::factory()->withName('Kelas Istimewa')->create();

    // Buat kelompok kelas tertentu
    Kelompok::factory()->forClass('A')->create();
    Kelompok::factory()->forClass('B')->create();

    // Buat kelompok tahfidz
    Kelompok::factory()->tahfidz()->create();

    // Buat multiple kelompok tahfidz
    Kelompok::factory()->tahfidz()->count(3)->create();

    // Buat kelompok dengan custom data
    Kelompok::factory()->create(['nama' => 'Kelompok Khusus']);

    // Lihat semua kelompok
    Kelompok::all();

    // Hitung jumlah kelompok
    Kelompok::count();
*/
