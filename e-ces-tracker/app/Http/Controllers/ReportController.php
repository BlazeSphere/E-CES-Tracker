<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Survey;
use App\Models\Community;
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
    public function index()
    {
        // 1. Stats
        $stats = [
            'totalProjects' => Project::count(),
            'completedSurveys' => Survey::count(),
            'totalVolunteers' => Project::sum('volunteers_count'),
            'activeCommunities' => Community::count(),
        ];

        // 2. Pie Chart: Group by category
        $distributionData = Project::select('category', DB::raw('count(*) as count'))
            ->whereNotNull('category')
            ->groupBy('category')
            ->get();

        // 3. Bar Chart: Monthly counts for current year
        $monthlyData = Project::select(
                DB::raw('count(*) as count'),
                DB::raw("DATE_FORMAT(created_at, '%b') as month"),
                DB::raw('MONTH(created_at) as month_num')
            )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'month_num')
            ->orderBy('month_num')
            ->get();

        // 4. Table: Latest 5 projects
        $projects = Project::latest()->take(5)->get();

        return view('reports.index', compact('stats', 'distributionData', 'monthlyData', 'projects'));
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
