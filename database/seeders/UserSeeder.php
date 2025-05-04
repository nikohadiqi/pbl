<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin
        $admin = User::create([
            'nim' => '111111',
            'password' => Hash::make('11111'),
            'role' => 'admin',
        ]);
        $adminToken = $admin->createToken('admin-token')->plainTextToken;
        echo "Admin Token: {$adminToken}\n";

        // Mahasiswa
        $mahasiswa = User::create([
            'nim' => '22222',
            'password' => Hash::make('22222'),
            'role' => 'mahasiswa',
        ]);
        $mahasiswaToken = $mahasiswa->createToken('mahasiswa-token')->plainTextToken;
        echo "Mahasiswa Token: {$mahasiswaToken}\n";

        // Dosen
        $dosen = User::create([
            'nim' => '33333',
            'password' => Hash::make('33333'),
            'role' => 'dosen',
        ]);
        $dosenToken = $dosen->createToken('dosen-token')->plainTextToken;
        echo "Dosen Token: {$dosenToken}\n";
    }
}
