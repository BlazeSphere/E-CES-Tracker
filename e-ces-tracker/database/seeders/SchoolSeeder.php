<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schools = [
            ['code' => 'SE', 'name' => 'School of Engineering'],
            ['code' => 'SOE', 'name' => 'School of Education'],
            ['code' => 'SOA', 'name' => 'School of Accountancy'],
            ['code' => 'SIT', 'name' => 'School of Information and Technology'],
            ['code' => 'SAS', 'name' => 'School of Arts and Sciences'],
            ['code' => 'SCJE', 'name' => 'School of Criminal Justice Education'],
            ['code' => 'SAFA', 'name' => 'School of Architecture and Fine Arts'],
            ['code' => 'SBHTM', 'name' => 'School of Business Hospitality Tourism Management'],
        ];

        foreach ($schools as $school) {
            School::updateOrCreate(
                ['code' => $school['code']],
                [
                    'name' => $school['name'],
                    'description' => '',
                ]
            );
        }
    }
}
