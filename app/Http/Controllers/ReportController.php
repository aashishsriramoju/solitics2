<?php

namespace App\Http\Controllers;

use App\Models\SoilReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->soilReports()->latest();

        // Optional search
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('health_status', $request->status);
        }

        $reports = $query->paginate(10)->withQueryString();

        return view('reports.index', compact('reports'));
    }

    public function show(SoilReport $soilReport)
    {
        Gate::authorize('view', $soilReport);
        return view('soil.analysis', ['report' => $soilReport]);
    }

    /**
     * Download PDF report — uses a lightweight HTML-to-PDF approach.
     * For production, install barryvdh/laravel-dompdf.
     */
    public function downloadPdf(SoilReport $soilReport)
    {
        Gate::authorize('view', $soilReport);

        // Render the report view as printable HTML
        $html = view('reports.pdf', ['report' => $soilReport])->render();

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'inline; filename="soilytics-report-' . $soilReport->id . '.html"');
    }
}
