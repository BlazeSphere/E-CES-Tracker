<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Survey;
use App\Models\Community;
use App\Models\School;
use App\Exports\ProjectReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as Pdf;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index(Request $request)
    {
        // 1. Capture filters
        $dateRange = $request->input('date_range');
        $category = $request->input('category');
        $department = $request->input('department');

        // Fetch all schools for the filter dropdown
        $schools = School::all();

        // Helper to apply filters to a query
        $applyFilters = function ($query) use ($dateRange, $category, $department) {
            $query->when($category && $category !== 'All Projects', function ($q) use ($category) {
                return $q->where('category', $category);
            });

            $query->when($department && $department !== 'All Departments', function ($q) use ($department) {
                return $q->where('department', $department);
            });

            if ($dateRange) {
                if ($dateRange === 'Last 30 Days') {
                    $query->where('created_at', '>=', now()->subDays(30));
                } elseif ($dateRange === 'Last Quarter') {
                    $query->where('created_at', '>=', now()->subMonths(3));
                } elseif ($dateRange === 'Current Year') {
                    $query->whereYear('created_at', date('Y'));
                }
            }

            return $query;
        };

        // 2. Stats
        $statsQuery = Project::query();
        $applyFilters($statsQuery);

        $stats = [
            'totalProjects' => $statsQuery->count(),
            'completedSurveys' => Survey::count(), 
            'totalVolunteers' => $statsQuery->sum('volunteers_count'),
            'activeCommunities' => Community::count(),
        ];

        // 3. Pie Chart: Group by category
        $distributionQuery = Project::select('category', DB::raw('count(*) as count'))
            ->whereNotNull('category');
        $applyFilters($distributionQuery);
        $distributionData = $distributionQuery->groupBy('category')->get();

        // 4. Bar Chart: Monthly counts for current year
        $monthlyQuery = Project::select(
                DB::raw('count(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw('MONTH(created_at) as month_num')
            )
            ->whereYear('created_at', date('Y'));
        $applyFilters($monthlyQuery);
        $monthlyData = $monthlyQuery->groupBy('month', 'month_num')
            ->orderBy('month_num')
            ->get();

        // 5. Table: Projects ordered by impact score (respecting filters)
        $projectsQuery = Project::query();
        $applyFilters($projectsQuery);
        $projects = $projectsQuery->orderBy('impact_score', 'desc')->take(5)->get();

        return view('reports.index', compact(
            'stats', 
            'distributionData', 
            'monthlyData', 
            'projects', 
            'dateRange', 
            'category', 
            'department',
            'schools'
        ));
    }

    /**
     * Export projects to Excel.
     */
    public function downloadExcel()
    {
        return Excel::download(new ProjectReportExport, 'projects-report-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export projects to PDF.
     */
    public function downloadPDF()
    {
        $projects = Project::with(['events.community'])->latest()->get();
        
        $pdf = Pdf::loadView('reports.pdf', compact('projects'));
        
        return $pdf->download('projects-report-' . date('Y-m-d') . '.pdf');
    }
}
