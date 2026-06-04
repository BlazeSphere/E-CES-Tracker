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
        return view('dashboard', [
            'activeProjectsCount' => Project::count(),
            'surveysCount' => Survey::count(),
            'volunteersCount' => User::count(), // Default to total users as placeholder for volunteers
            'communitiesCount' => Community::count(),
            'projects' => Project::with('user')->latest()->take(5)->get(),
            'auditLogs' => AuditLog::with('user')->latest()->take(5)->get(),
        ]);
    }
}
