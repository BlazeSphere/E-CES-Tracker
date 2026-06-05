<?php

namespace Database\Seeders;

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
        User::updateOrCreate(
            ['email' => 'SuperAdmin@dwcc.edu.ph'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('ADMIN123'),
                'role' => 0,
                'status' => 'active',
                'id_number' => 'ADMIN-001',
            ]
        );

        User::updateOrCreate(
            ['email' => 'sit.admin@dwcc.edu.ph'],
            [
                'name' => 'Divina Rivera',
                'password' => Hash::make('ADMIN123'),
                'role' => 1,
                'status' => 'active',
                'id_number' => 'SIT-001',
                'department' => 'SIT',
            ]
        );

        $this->call([
            SchoolSeeder::class,
            ProjectSeeder::class,
        ]);
    }
}
