<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = \App\Models\User::where('role', 0)->first();
        $sitAdmin = \App\Models\User::where('department', 'SIT')->first();
        $schoolCodes = \App\Models\School::pluck('code')->toArray();
        
        if (!$superAdmin || empty($schoolCodes)) {
            return;
        }

        $categories = ['Outreach', 'Environmental', 'Educational', 'Health'];
        $statuses = ['planned', 'ongoing', 'completed'];

        // Seed SIT specific projects for the Admin Dashboard
        for ($i = 1; $i <= 3; $i++) {
            Project::create([
                'project_name' => "SIT Initiative $i: " . ['Coastal Clean-up SIT', 'IT Literacy Program', 'Hardware Repair Drive'][$i-1],
                'description' => 'A dedicated SIT project focusing on community development through technology and service.',
                'category' => $categories[array_rand($categories)],
                'department' => 'SIT',
                'status' => 'ongoing',
                'budget' => rand(10000, 25000),
                'volunteers_count' => rand(20, 50),
                'beneficiaries_count' => rand(100, 300),
                'completion_percentage' => rand(30, 70),
                'impact_score' => (rand(40, 50) / 10),
                'user_id' => $sitAdmin->id ?? $superAdmin->id,
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
        }

        // Seed SIT specific surveys
        for ($i = 1; $i <= 3; $i++) {
            \App\Models\Survey::create([
                'title' => "Survey for Community Service in Pachoca - SIT Edition $i",
                'respondents_count' => rand(30, 80),
                'satisfaction_score' => (rand(40, 50) / 10),
                'department' => 'SIT',
                'form_data' => json_encode(['q1' => 'Was the service helpful?']),
                'created_by' => $sitAdmin->id ?? $superAdmin->id,
            ]);
        }

        // Randomly seed other projects
        for ($i = 1; $i <= 7; $i++) {
            $status = $statuses[array_rand($statuses)];
            $completion = $status === 'completed' ? 100 : ($status === 'planned' ? 0 : rand(10, 90));
            
            Project::create([
                'project_name' => "Institutional Project $i: " . ['Tree Planting', 'Literacy Drive', 'Medical Mission', 'Coastal Cleanup', 'Coding Workshop'][array_rand(['Tree Planting', 'Literacy Drive', 'Medical Mission', 'Coastal Cleanup', 'Coding Workshop'])],
                'description' => 'A sample project generated for testing reports and analytics dashboards.',
                'category' => $categories[array_rand($categories)],
                'department' => $schoolCodes[array_rand($schoolCodes)],
                'status' => $status,
                'budget' => rand(5000, 50000),
                'volunteers_count' => rand(5, 50),
                'beneficiaries_count' => rand(50, 500),
                'completion_percentage' => $completion,
                'impact_score' => (rand(30, 50) / 10), 
                'user_id' => $superAdmin->id,
                'created_at' => now()->subMonths(rand(0, 5)),
            ]);
        }
    }
}
