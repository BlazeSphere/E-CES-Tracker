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
    public function index()
    {
        $user = Auth::user();
        $query = Survey::query();

        // If standard Admin, filter by their department
        if ($user->role === User::ROLE_ADMIN && $user->department) {
            $query->where('department', $user->department);
        }

        $surveys = $query->with('creator')->withCount('questions')->latest()->paginate(10);

        return view('surveys.index', compact('surveys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('surveys.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,active,closed',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string|max:255',
            'questions.*.type' => 'required|in:text,scale,multiple_choice',
            'questions.*.required' => 'nullable|boolean',
            'questions.*.choices' => 'nullable|array',
            'questions.*.choices.*' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            $survey = Survey::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'status' => $validated['status'],
                'department' => $user->department,
                'created_by' => $user->id,
                'form_data' => json_encode([]),
            ]);

            foreach ($validated['questions'] as $questionData) {
                $survey->questions()->create([
                    'question_text' => $questionData['text'],
                    'type' => $questionData['type'],
                    'is_required' => $questionData['required'] ?? false,
                    'choices' => $questionData['type'] === 'multiple_choice' ? ($questionData['choices'] ?? []) : null,
                ]);
            }

            DB::commit();

            return redirect()->route('surveys.index')->with('success', 'Survey created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Failed to create survey: ' . $e->getMessage());
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
