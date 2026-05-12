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
            ]
        );
    }
}
