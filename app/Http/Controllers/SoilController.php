<?php

namespace App\Http\Controllers;

use App\Models\SoilReport;
use App\Services\GeminiService;
use App\Services\SoilAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class SoilController extends Controller
{
    public function __construct(
        private SoilAnalysisService $analysisService,
        private GeminiService       $geminiService
    ) {}

    // ─── Upload page ──────────────────────────────────────────────────────────

    public function showUpload()
    {
        return view('soil.upload');
    }

    // ─── Store & analyse ──────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'soil_image'    => ['nullable', 'image', 'max:8192'],
            'title'         => ['nullable', 'string', 'max:200'],
            'ph_level'      => ['nullable', 'numeric', 'min:0', 'max:14'],
            'nitrogen'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'phosphorus'    => ['nullable', 'numeric', 'min:0', 'max:100'],
            'potassium'     => ['nullable', 'numeric', 'min:0', 'max:100'],
            'moisture'      => ['nullable', 'numeric', 'min:0', 'max:100'],
            'organic_matter' => ['nullable', 'numeric', 'min:0', 'max:20'],
            'location'      => ['nullable', 'string', 'max:200'],
        ]);

        // Require either a soil photo upload OR manual parameter metrics
        if (!$request->hasFile('soil_image') && $request->ph_level === null && $request->nitrogen === null) {
            return redirect()->back()->withErrors([
                'soil_image' => 'Please upload a soil photo for AI analysis or enter manual parameters.',
            ])->withInput();
        }

        // Store image
        $imagePath = null;
        if ($request->hasFile('soil_image')) {
            $imagePath = $request->file('soil_image')->store('soil-images', 'public');
        }

        // Gemini Vision analysis (if image uploaded)
        $aiData = null;
        if ($imagePath) {
            $fullPath = Storage::disk('public')->path($imagePath);
            $aiData   = $this->geminiService->analyzeSoilImage($fullPath);
        }

        if ($aiData) {
            // PHOTO ANALYSIS MODE - 100% driven by AI photo parameters
            $ph             = $aiData['ph_level'] ?? 7.0;
            $nitrogen       = $aiData['nitrogen'] ?? 50;
            $phosphorus     = $aiData['phosphorus'] ?? 50;
            $potassium      = $aiData['potassium'] ?? 50;
            $moisture       = $aiData['moisture'] ?? 50;
            $organic_matter = $aiData['organic_matter'] ?? 3.0;

            $soilType       = $aiData['soil_type'] ?? 'Unknown Soil';
            $healthScore    = $aiData['health_score'] ?? 70;
            $healthStatus   = $aiData['health_status'] ?? 'Moderate';
            $soilPHCategory = ($ph < 5.5) ? 'Strongly Acidic' : (($ph < 6.0) ? 'Moderately Acidic' : (($ph <= 7.5) ? 'Neutral' : (($ph <= 8.5) ? 'Slightly Alkaline' : 'Strongly Alkaline')));
            $soilCondition  = $aiData['analysis'] ?? 'AI photo assessment complete.';
            $deficiencies   = $aiData['deficiencies'] ?? [];
            $fertilizers    = $aiData['fertilizer_recommendations'] ?? [];
            $crops          = $aiData['crop_recommendations'] ?? [];

            $aiAnalysis     = $aiData['analysis'];
            $aiSoilType     = $soilType;
            $aiRecommendations = is_array($fertilizers) ? json_encode($fertilizers) : null;
        } else {
            // MANUAL SLIDER MODE - driven by manual rule-based calculations
            $ph             = (float) ($request->ph_level ?? 7.0);
            $nitrogen       = (float) ($request->nitrogen ?? 50);
            $phosphorus     = (float) ($request->phosphorus ?? 50);
            $potassium      = (float) ($request->potassium ?? 50);
            $moisture       = (float) ($request->moisture ?? 50);
            $organic_matter = (float) ($request->organic_matter ?? 3.0);

            $analysis = $this->analysisService->analyze([
                'ph'            => $ph,
                'nitrogen'      => $nitrogen,
                'phosphorus'    => $phosphorus,
                'potassium'     => $potassium,
                'moisture'      => $moisture,
                'organic_matter' => $organic_matter,
            ]);

            $soilType       = $analysis['soil_type'];
            $soilPHCategory = $analysis['soil_ph_category'];
            $healthScore    = $analysis['health_score'];
            $healthStatus   = $analysis['health_status'];
            $soilCondition  = $analysis['soil_condition'];
            $deficiencies   = $analysis['deficiencies'];
            $fertilizers    = $analysis['fertilizer_recommendations'];
            $crops          = $analysis['crop_recommendations'];

            $aiAnalysis     = null;
            $aiSoilType     = null;
            $aiRecommendations = null;
        }

        // Create report
        $report = SoilReport::create([
            'user_id'                    => Auth::id(),
            'image_path'                 => $imagePath,
            'title'                      => $request->title ?: 'Soil Analysis Report',
            'ph_level'                   => $ph,
            'nitrogen'                   => $nitrogen,
            'phosphorus'                 => $phosphorus,
            'potassium'                  => $potassium,
            'moisture'                   => $moisture,
            'organic_matter'             => $organic_matter,
            'location'                   => $request->location,
            'soil_type'                  => $soilType,
            'soil_ph_category'           => $soilPHCategory,
            'health_score'               => $healthScore,
            'health_status'              => $healthStatus,
            'soil_condition'             => $soilCondition,
            'deficiencies'               => $deficiencies,
            'fertilizer_recommendations' => $fertilizers,
            'crop_recommendations'       => $crops,
            'ai_analysis'                => $aiAnalysis,
            'ai_soil_type'               => $aiSoilType,
            'ai_recommendations'         => $aiRecommendations,
            'status'                     => 'analyzed',
        ]);

        return redirect()->route('soil.analysis', $report->id)
                         ->with('success', 'Soil analysis complete!');
    }

    // ─── Analysis result page ─────────────────────────────────────────────────

    public function analysis(SoilReport $soilReport)
    {
        Gate::authorize('view', $soilReport);
        return view('soil.analysis', ['report' => $soilReport]);
    }

    // ─── Delete ───────────────────────────────────────────────────────────────

    public function destroy(SoilReport $soilReport)
    {
        Gate::authorize('delete', $soilReport);

        if ($soilReport->image_path) {
            Storage::disk('public')->delete($soilReport->image_path);
        }

        $soilReport->delete();
        return redirect()->route('reports')
                         ->with('success', 'Report deleted successfully.');
    }
}
