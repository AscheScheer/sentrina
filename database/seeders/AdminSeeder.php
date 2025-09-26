<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	if(Admin::where("email","nurulamalhrd@gmail.com")->first())return;
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'nurulamalhrd@gmail.com',
            'password' => Hash::make('Nurulamal!@#'),
        ]);
    }
}
