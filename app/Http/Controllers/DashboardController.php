<?php

namespace App\Http\Controllers;

use App\Models\MarketPrice;
use App\Models\SoilReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user        = Auth::user();
        $reports     = $user->soilReports()->latest()->take(5)->get();
        $latestReport = $reports->first();
        $totalReports = $user->soilReports()->count();
        $marketPrices = MarketPrice::orderBy('price_date', 'desc')->take(6)->get();

        // Chart data — last 7 reports
        $chartReports = $user->soilReports()->latest()->take(7)->get()->reverse()->values();
        $chartLabels  = $chartReports->map(fn($r) => $r->created_at->format('d M'));
        $chartScores  = $chartReports->map(fn($r) => $r->health_score ?? 0);

        // Nutrient data from latest report
        $nutrients = [];
        if ($latestReport) {
            $nutrients = [
                'pH'           => ($latestReport->ph_level    ?? 7) * 10,  // scale to 0-100
                'Nitrogen'     => $latestReport->nitrogen     ?? 0,
                'Phosphorus'   => $latestReport->phosphorus   ?? 0,
                'Potassium'    => $latestReport->potassium    ?? 0,
                'Moisture'     => $latestReport->moisture     ?? 0,
                'Organic'      => ($latestReport->organic_matter ?? 0) * 10,
            ];
        }

        return view('dashboard', compact(
            'user', 'reports', 'latestReport', 'totalReports',
            'marketPrices', 'chartLabels', 'chartScores', 'nutrients'
        ));
    }
}
