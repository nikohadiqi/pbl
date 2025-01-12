<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seeder untuk role admin
        User::create([
            'nim' => '12345601',
            'password' => Hash::make('admin123'), // Password di-hash
            'role' => 'admin',
        ]);

        // Seeder untuk role mahasiswa
        User::create([
            'nim' => '12345602',
            'password' => Hash::make('mahasiswa123'), // Password di-hash
            'role' => 'mahasiswa',
        ]);

        // Seeder untuk role manajer proyek
        User::create([
            'nim' => '12345603',
            'password' => Hash::make('manajer123'), // Password di-hash
            'role' => 'manajerproyek',
        ]);
    }
}
