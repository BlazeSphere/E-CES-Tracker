<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Survey::query()->with(['creator', 'project']);

        // If standard Admin, filter by their department
        if ($user->role === User::ROLE_ADMIN && $user->department) {
            $query->where('department', $user->department);
        }

        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        $surveys = $query->withCount('questions')->latest()->paginate(10)->appends($request->all());

        // Fetch projects for the filter dropdown
        $projectQuery = \App\Models\Project::query();
        if ($user->role === User::ROLE_ADMIN && $user->department) {
            $projectQuery->where('department', $user->department);
        }
        $projects = $projectQuery->get();
        $selectedProject = $request->project_id;

        return view('surveys.index', compact('surveys', 'projects', 'selectedProject'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $query = \App\Models\Project::query();
        
        if ($user->role === User::ROLE_ADMIN && $user->department) {
            $query->where('department', $user->department);
        }
        
        $projects = $query->latest()->get();
        
        return view('surveys.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active,closed',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string|max:255',
            'questions.*.type' => 'required|in:text,scale,multiple_choice',
            'questions.*.is_required' => 'nullable',
            'questions.*.choices' => 'nullable|array',
            'questions.*.choices.*' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $survey = Survey::create([
                    'project_id' => $validated['project_id'],
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'status' => $validated['status'],
                    'department' => auth()->user()->department,
                    'created_by' => auth()->id(),
                    'form_data' => json_encode([]),
                ]);

                foreach ($validated['questions'] as $questionData) {
                    $survey->questions()->create([
                        'question_text' => $questionData['question_text'],
                        'type' => $questionData['type'],
                        'is_required' => isset($questionData['is_required']) ? filter_var($questionData['is_required'], FILTER_VALIDATE_BOOLEAN) : false,
                        'choices' => $questionData['type'] === 'multiple_choice' ? ($questionData['choices'] ?? []) : null,
                    ]);
                }
            });

            return redirect()->route('surveys.index')->with('success', 'Survey built and saved successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Survey $survey)
    {
        return view('surveys.show', compact('survey'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Survey $survey)
    {
        // Simple authorization check
        if (Auth::user()->role === User::ROLE_ADMIN && $survey->department !== Auth::user()->department) {
            abort(403);
        }

        return view('surveys.edit', compact('survey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Survey $survey)
    {
        if (Auth::user()->role === User::ROLE_ADMIN && $survey->department !== Auth::user()->department) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active,closed',
        ]);

        $survey->update($validated);

        return redirect()->route('surveys.index')->with('success', 'Survey updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Survey $survey)
    {
        if (Auth::user()->role === User::ROLE_ADMIN && $survey->department !== Auth::user()->department) {
            abort(403);
        }

        $survey->delete();

        return redirect()->route('surveys.index')->with('success', 'Survey deleted successfully.');
    }
}
