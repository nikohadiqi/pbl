<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Seeder untuk role admin
        User::create([
            'nim' => '111111',
            'password' => Hash::make('11111'),  // Password yang di-hash
            'role' => 'admin',
        ]);

        // Seeder untuk role mahasiswa
        User::create([
            'nim' => '22222',
            'password' => Hash::make('22222'),  // Password yang di-hash
            'role' => 'mahasiswa',
        ]);

        // Seeder untuk role dosen
        User::create([
            'nim' => '33333',
            'password' => Hash::make('33333'),  // Password yang di-hash
            'role' => 'dosen',
        ]);
    }
}
