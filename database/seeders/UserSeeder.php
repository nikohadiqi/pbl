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
        // Admin 1
        User::create([
            'nim' => 'adminsimpbl',
            'nama' => 'Admin SIMPBL',
            'password' => Hash::make('admin123!@#'),
            'role' => 'admin',
        ]);

        // Admin Bu Dian
        User::create([
            'nim' => '198711032021212001',
            'nama' => 'Dian Mujiani, SE',
            'password' => Hash::make('198711032021212001'),
            'role' => 'admin',
        ]);

        // Admin Pak Arya
        User::create([
            'nim' => '198103232014041001',
            'nama' => 'Arya Pramudita, SE',
            'password' => Hash::make('198103232014041001'),
            'role' => 'admin',
        ]);
    }
}
