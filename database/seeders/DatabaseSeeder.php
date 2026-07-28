<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRole = Role::create(['role_name' => 'admin']);
        $userRole = Role::create(['role_name' => 'user']);

        User::create([
            'nama' => 'Admin Pakar',
            'username' => 'admin@pakar.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'nama' => 'Mauhamad Isa Nur Fadhilah',
            'username' => 'muhamadisa',
            'password' => Hash::make('pasien123'),
            'role_id' => $userRole->id,
        ]);
    }
}
