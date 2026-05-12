<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Survey;
use App\Models\User;
use App\Models\Community;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'activeProjectsCount' => Project::count(),
            'surveysCount' => Survey::count(),
            'volunteersCount' => 0, // Roles for volunteers not yet defined as integers
            'communitiesCount' => Community::count(),
            'projects' => Project::with(['events.community'])->latest()->take(5)->get(),
        ]);
    }
}
