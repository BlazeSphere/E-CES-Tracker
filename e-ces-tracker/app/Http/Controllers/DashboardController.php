<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Survey;
use App\Models\User;
use App\Models\Community;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isSuperAdmin = $user->role === User::ROLE_SUPER_ADMIN;
        $department = $user->department;

        $projectQuery = Project::query();
        $surveyQuery = Survey::query();
        $communityQuery = Community::query();
        $auditLogQuery = AuditLog::with('user');

        if (!$isSuperAdmin && $department) {
            $projectQuery->where('department', $department);
            $surveyQuery->whereHas('creator', function ($q) use ($department) {
                $q->where('department', $department);
            });
            $communityQuery->whereHas('projects', function ($q) use ($department) {
                $q->where('department', $department);
            });
            $auditLogQuery->whereHas('user', function ($q) use ($department) {
                $q->where('department', $department);
            });
        }

        // Fetch Data for Admin Screenshot
        $activeProjects = (clone $projectQuery)->where('status', 'ongoing')->latest()->get();
        $latestProject = (clone $projectQuery)->where('status', 'ongoing')->with('user')->latest()->first();
        
        // If Super Admin, show members from any department; otherwise, restrict to user's department
        $projectMembers = $latestProject 
            ? User::when(!$isSuperAdmin, function($q) use ($department) {
                return $q->where('department', $department);
            })->take(3)->get() 
            : collect();

        $recentSurveys = (clone $surveyQuery)->latest()->take(3)->get();

        $data = [
            'activeProjectsCount' => (clone $projectQuery)->where('status', 'ongoing')->count(),
            'communitiesCount' => $communityQuery->count(),
            'volunteersCount' => (clone $projectQuery)->sum('volunteers_count'),
            
            'activeProjectsList' => $activeProjects,
            'latestProject' => $latestProject,
            'projectMembers' => $projectMembers,
            'recentSurveys' => $recentSurveys,
            
            // Keeping existing variables for compatibility
            'surveysCount' => $surveyQuery->count(),
            'projects' => $projectQuery->with('user')->latest()->take(5)->get(),
            'auditLogs' => $auditLogQuery->latest()->take(5)->get(),
        ];

        if ($user->role === User::ROLE_ADMIN) {
            return view('admin.dashboard', $data);
        }

        return view('dashboard', $data);
    }
}
