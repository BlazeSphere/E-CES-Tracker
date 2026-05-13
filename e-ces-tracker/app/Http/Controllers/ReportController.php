<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Exports\ProjectReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as Pdf;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports.
     */
    public function index()
    {
        return view('reports.index');
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
