<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'Admin User',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('admin@admin.com')
        ]);

        User::create([
            'nama_lengkap' => 'Penjual User',
            'email' => 'penjual@penjual.com',
            'role' => 'penjual',
            'password' => Hash::make('penjual@penjual.com')
        ]);

        User::create([
            'nama_lengkap' => 'Pembeli User',
            'email' => 'pembeli@pembeli.com',
            'role' => 'pembeli',
            'password' => Hash::make('pembeli@pembeli.com')
        ]);
    }
}
