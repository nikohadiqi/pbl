<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\AkunMahasiswa;
use App\Models\AkunDosen;

class UserSeeder extends Seeder
{
    public function run()
    {

        $mahasiswa = AkunMahasiswa::first();
        // Admin
        User::create([
            'nim' => '111111',
            'password' => Hash::make('11111'),
            'role' => 'admin',
        ]);

        // Admin Bu Dian
        User::create([
            'nim' => '198711032021212001',
            'password' => Hash::make('198711032021212001'),
            'role' => 'admin',
        ]);

        // Admin Pak Arya
        User::create([
            'nim' => '198103232014041001',
            'password' => Hash::make('198103232014041001'),
            'role' => 'admin',
        ]);

        // Mahasiswa - Use AkunMahasiswa model if needed
        $mahasiswa = AkunMahasiswa::create([
            'nim' => '22222',
            'password' => Hash::make('22222'),
            'role' => 'mahasiswa',
        ]);
        // $mahasiswaToken = $mahasiswa->createToken('mahasiswa-token')->plainTextToken;
        // echo "Mahasiswa Token: {$mahasiswaToken}\n";

        // Dosen
        $dosen = AkunDosen::create([
            'nim' => '33333',
            'password' => Hash::make('33333'),
            'role' => 'dosen',
        ]);
        // $dosenToken = $dosen->createToken('dosen-token')->plainTextToken;
        // echo "Dosen Token: {$dosenToken}\n";
    }
}
