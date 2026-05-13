<?php

namespace App\Exports;

use App\Models\Project;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProjectReportExport implements FromView, ShouldAutoSize
{
    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.projects', [
            'projects' => Project::with(['events.community'])->latest()->get()
        ]);
    }
}
