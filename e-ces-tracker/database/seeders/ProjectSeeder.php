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
        $adminId = \App\Models\User::first()?->id;
        
        if (!$adminId) {
            return;
        }

        $categories = ['Outreach', 'Environmental', 'Educational', 'Health'];
        $departments = ['CS Department', 'Education Department', 'Nursing Department', 'Business Department', 'Engineering Department'];
        $statuses = ['planned', 'ongoing', 'completed'];

        for ($i = 1; $i <= 10; $i++) {
            $status = $statuses[array_rand($statuses)];
            $completion = $status === 'completed' ? 100 : ($status === 'planned' ? 0 : rand(10, 90));
            
            Project::create([
                'project_name' => "Sample Project $i: " . ['Tree Planting', 'Literacy Drive', 'Medical Mission', 'Coastal Cleanup', 'Coding Workshop'][array_rand(['Tree Planting', 'Literacy Drive', 'Medical Mission', 'Coastal Cleanup', 'Coding Workshop'])],
                'description' => 'A sample project generated for testing reports and analytics dashboards.',
                'category' => $categories[array_rand($categories)],
                'department' => $departments[array_rand($departments)],
                'status' => $status,
                'budget' => rand(5000, 50000),
                'volunteers_count' => rand(5, 50),
                'beneficiaries_count' => rand(50, 500),
                'completion_percentage' => $completion,
                'impact_score' => (rand(30, 50) / 10), // Random score between 3.0 and 5.0
                'user_id' => $adminId,
                'created_at' => now()->subMonths(rand(0, 5)), // Spread across recent months for bar chart
            ]);
        }
    }
}
