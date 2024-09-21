<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role' => 'admin'
        ]);

        User::factory()->create([
            'name' => 'Owner Apotek',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('owner'),
            'role' => 'owner'
        ]);

        User::factory()->create([
            'name' => 'Supplier Obat',
            'email' => 'supplier@gmail.com',
            'password' => Hash::make('supplier'),
            'role' => 'supplier'
        ]);

        User::factory()->create([
            'name' => 'Kasir Mantap',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('kasir'),
            'role' => 'kasir'
        ]);

        User::factory()->create([
            'name' => 'Ini Pelanggan',
            'email' => 'pelanggan@gmail.com',
            'password' => Hash::make('pelanggan'),
            'role' => 'pelanggan'
        ]);
    }
}
