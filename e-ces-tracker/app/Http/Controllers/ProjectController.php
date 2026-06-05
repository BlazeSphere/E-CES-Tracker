<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Project::query();

        // Capture filters from request
        $search = $request->get('search');
        $status = $request->get('status');
        $department = $request->get('department');

        // Apply department restriction for non-Super Admins
        if ($user && $user->role !== User::ROLE_SUPER_ADMIN && $user->department) {
            $query->where('department', $user->department);
        }

        // Apply Filters
        $query->when($search, function ($q) use ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('project_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->when($status, function ($q) use ($status) {
            $q->where('status', $status);
        })
        ->when($department, function ($q) use ($department) {
            $q->where('department', $department);
        });

        // Fetch counts for stat cards based on filtered query
        $stats = [
            'total' => (clone $query)->count(),
            'completed' => (clone $query)->where('status', 'Completed')->count(),
            'ongoing' => (clone $query)->where('status', 'In Progress')->count(),
            'pending' => (clone $query)->where('status', 'Planned')->count(),
        ];

        $projects = $query->with(['user', 'adoptedCommunity'])->latest()->paginate(9)->appends($request->all());
        $users = User::where('department', $user->department)->get();
        $schools = School::all();
        $communities = \App\Models\AdoptedCommunity::all();

        return view('projects.index', compact('projects', 'stats', 'users', 'schools', 'communities', 'search', 'status', 'department'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch eligible persons in charge (staff from the same department)
        $users = User::where('department', Auth::user()->department)->get();
        return view('projects.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'user_id' => 'required|exists:users,id', // Person in Charge
            'adopted_community_id' => 'nullable|exists:adopted_communities,id',
        ]);

        $validated['department'] = Auth::user()->department;

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorizeAccess($project);
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $this->authorizeAccess($project);
        $users = User::where('department', Auth::user()->department)->get();
        return view('projects.edit', compact('project', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $this->authorizeAccess($project);

        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'status' => 'required|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0',
            'user_id' => 'required|exists:users,id',
            'adopted_community_id' => 'nullable|exists:adopted_communities,id',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage. (Archive/Soft Delete)
     */
    public function destroy(Project $project)
    {
        $this->authorizeAccess($project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project moved to archive.');
    }

    /**
     * Restore a soft-deleted project.
     */
    public function restore($id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $this->authorizeAccess($project);
        
        $project->restore();

        return redirect()->route('projects.index')->with('success', 'Project restored from archive.');
    }

    /**
     * Internal helper to authorize department-level access.
     */
    protected function authorizeAccess(Project $project)
    {
        $user = Auth::user();
        if ($user && $user->role !== User::ROLE_SUPER_ADMIN && $project->department !== $user->department) {
            abort(403, 'Unauthorized access to project.');
        }
    }
}
