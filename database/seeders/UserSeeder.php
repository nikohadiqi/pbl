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
        User::create([
            'nim' => '111111',
            'password' => Hash::make('11111'),
            'role' => 'admin',
        ]);

        // Admin Bu Dian
        User::create([
            'nim' => '198711032021212001',
            'password' => Hash::make('198711032021212001'),  // Password yang di-hash
            'role' => 'admin',
        ]);

        // Admin Pak Arya
        User::create([
            'nim' => '198103232014041001',
            'password' => Hash::make('198103232014041001'),  // Password yang di-hash
            'role' => 'admin',
        ]);

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
