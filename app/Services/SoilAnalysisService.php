<?php

namespace App\Services;

/**
 * Rule-based soil analysis engine.
 * All logic is deterministic based on input nutrient values.
 */
class SoilAnalysisService
{
    /**
     * Run a complete analysis on the given soil parameters.
     *
     * @param  array{ph: float, nitrogen: float, phosphorus: float, potassium: float, moisture: float, organic_matter: float}  $params
     * @return array
     */
    public function analyze(array $params): array
    {
        $ph           = (float) ($params['ph']           ?? 7.0);
        $nitrogen     = (float) ($params['nitrogen']     ?? 50);
        $phosphorus   = (float) ($params['phosphorus']   ?? 50);
        $potassium    = (float) ($params['potassium']    ?? 50);
        $moisture     = (float) ($params['moisture']     ?? 50);
        $organicMatter = (float) ($params['organic_matter'] ?? 3);

        $phCategory   = $this->classifyPH($ph);
        $soilType     = $this->determineSoilType($ph, $moisture, $organicMatter);
        $deficiencies = $this->detectDeficiencies($nitrogen, $phosphorus, $potassium, $ph, $moisture, $organicMatter);
        $fertilizers  = $this->recommendFertilizers($deficiencies, $ph);
        $crops        = $this->recommendCrops($ph, $nitrogen, $phosphorus, $potassium, $moisture);
        $score        = $this->calculateHealthScore($ph, $nitrogen, $phosphorus, $potassium, $moisture, $organicMatter);
        $status       = $this->healthStatus($score);
        $condition    = $this->soilConditionSummary($ph, $nitrogen, $phosphorus, $potassium, $moisture, $organicMatter, $phCategory);

        return [
            'soil_type'                  => $soilType,
            'soil_ph_category'           => $phCategory,
            'health_score'               => $score,
            'health_status'              => $status,
            'soil_condition'             => $condition,
            'deficiencies'               => $deficiencies,
            'fertilizer_recommendations' => $fertilizers,
            'crop_recommendations'       => $crops,
        ];
    }

    // ─── pH ───────────────────────────────────────────────────────────────────

    private function classifyPH(float $ph): string
    {
        if ($ph < 5.5)             return 'Strongly Acidic';
        if ($ph >= 5.5 && $ph < 6) return 'Moderately Acidic';
        if ($ph >= 6 && $ph <= 7.5) return 'Neutral';
        if ($ph > 7.5 && $ph <= 8.5) return 'Slightly Alkaline';
        return 'Strongly Alkaline';
    }

    // ─── Soil type ────────────────────────────────────────────────────────────

    private function determineSoilType(float $ph, float $moisture, float $organicMatter): string
    {
        if ($moisture < 20 && $organicMatter < 2)  return 'Sandy Soil';
        if ($moisture > 70 && $ph < 6)             return 'Clay Soil';
        if ($organicMatter >= 5)                   return 'Loamy Soil (Rich)';
        if ($ph > 7.5 && $moisture < 40)           return 'Black Cotton Soil';
        if ($ph >= 6 && $ph <= 7 && $moisture >= 40 && $moisture <= 60) return 'Red Loam Soil';
        if ($ph < 5.5)                             return 'Laterite Soil';
        return 'Loamy Soil';
    }

    // ─── Deficiencies ─────────────────────────────────────────────────────────

    private function detectDeficiencies(
        float $n, float $p, float $k,
        float $ph, float $moisture, float $organicMatter
    ): array {
        $def = [];

        if ($n < 40)           $def[] = ['nutrient' => 'Nitrogen (N)',     'level' => 'Low',      'severity' => 'high'];
        elseif ($n < 60)       $def[] = ['nutrient' => 'Nitrogen (N)',     'level' => 'Moderate', 'severity' => 'medium'];

        if ($p < 30)           $def[] = ['nutrient' => 'Phosphorus (P)',   'level' => 'Low',      'severity' => 'high'];
        elseif ($p < 50)       $def[] = ['nutrient' => 'Phosphorus (P)',   'level' => 'Moderate', 'severity' => 'medium'];

        if ($k < 40)           $def[] = ['nutrient' => 'Potassium (K)',    'level' => 'Low',      'severity' => 'high'];
        elseif ($k < 60)       $def[] = ['nutrient' => 'Potassium (K)',    'level' => 'Moderate', 'severity' => 'medium'];

        if ($moisture < 20)    $def[] = ['nutrient' => 'Moisture',         'level' => 'Very Low', 'severity' => 'high'];
        elseif ($moisture < 35) $def[] = ['nutrient' => 'Moisture',        'level' => 'Low',      'severity' => 'medium'];

        if ($organicMatter < 1.5) $def[] = ['nutrient' => 'Organic Matter', 'level' => 'Low',    'severity' => 'high'];
        elseif ($organicMatter < 3) $def[] = ['nutrient' => 'Organic Matter', 'level' => 'Moderate', 'severity' => 'medium'];

        if ($ph < 5.5 || $ph > 8.5) $def[] = ['nutrient' => 'pH Balance', 'level' => 'Critical', 'severity' => 'high'];

        return $def;
    }

    // ─── Fertilizer recommendations ───────────────────────────────────────────

    private function recommendFertilizers(array $deficiencies, float $ph): array
    {
        $fertilizers = [];
        $defNames    = array_column($deficiencies, 'nutrient');

        if (in_array('Nitrogen (N)', $defNames)) {
            $severity = collect($deficiencies)->firstWhere('nutrient', 'Nitrogen (N)')['severity'] ?? 'medium';
            $fertilizers[] = [
                'name'     => 'Urea (46-0-0)',
                'dose'     => $severity === 'high' ? '80–100 kg/acre' : '40–60 kg/acre',
                'timing'   => 'Split application — 50% basal, 50% top dressing',
                'type'     => 'Chemical',
                'priority' => $severity === 'high' ? 'High' : 'Medium',
            ];
        }

        if (in_array('Phosphorus (P)', $defNames)) {
            $fertilizers[] = [
                'name'     => 'DAP (18-46-0)',
                'dose'     => '50–70 kg/acre',
                'timing'   => 'Basal application before sowing',
                'type'     => 'Chemical',
                'priority' => 'High',
            ];
        }

        if (in_array('Potassium (K)', $defNames)) {
            $fertilizers[] = [
                'name'     => 'MOP / Potash (0-0-60)',
                'dose'     => '40–50 kg/acre',
                'timing'   => 'Basal or split application',
                'type'     => 'Chemical',
                'priority' => 'Medium',
            ];
        }

        if (in_array('Organic Matter', $defNames)) {
            $fertilizers[] = [
                'name'     => 'Farmyard Manure (FYM)',
                'dose'     => '4–6 tonnes/acre',
                'timing'   => '3–4 weeks before sowing',
                'type'     => 'Organic',
                'priority' => 'High',
            ];
            $fertilizers[] = [
                'name'     => 'Vermicompost',
                'dose'     => '1–2 tonnes/acre',
                'timing'   => 'Mix with soil before planting',
                'type'     => 'Organic',
                'priority' => 'Medium',
            ];
        }

        if ($ph < 5.5) {
            $fertilizers[] = [
                'name'     => 'Agricultural Lime (CaCO₃)',
                'dose'     => '500–800 kg/acre',
                'timing'   => '1 month before cultivation',
                'type'     => 'Amendment',
                'priority' => 'High',
            ];
        }

        if ($ph > 8.0) {
            $fertilizers[] = [
                'name'     => 'Gypsum (CaSO₄)',
                'dose'     => '200–400 kg/acre',
                'timing'   => 'Applied to soil and mixed',
                'type'     => 'Amendment',
                'priority' => 'High',
            ];
        }

        // Always recommend a micronutrient
        $fertilizers[] = [
            'name'     => 'Zinc Sulphate (ZnSO₄)',
            'dose'     => '10–15 kg/acre',
            'timing'   => 'Soil application at sowing',
            'type'     => 'Micronutrient',
            'priority' => 'Low',
        ];

        return $fertilizers;
    }

    // ─── Crop recommendations ─────────────────────────────────────────────────

    private function recommendCrops(float $ph, float $n, float $p, float $k, float $moisture): array
    {
        $crops = [];

        // Suitable for most soils
        if ($ph >= 6 && $ph <= 7.5 && $moisture >= 40) {
            $crops[] = ['name' => 'Rice',      'season' => 'Kharif (Jun–Oct)',  'suitability' => 'Excellent', 'water' => 'High'];
            $crops[] = ['name' => 'Wheat',     'season' => 'Rabi (Nov–Mar)',    'suitability' => 'Excellent', 'water' => 'Moderate'];
        }

        if ($ph >= 5.5 && $ph <= 8 && $moisture >= 30) {
            $crops[] = ['name' => 'Maize',     'season' => 'Kharif / Rabi',     'suitability' => 'Good',      'water' => 'Moderate'];
            $crops[] = ['name' => 'Soybean',   'season' => 'Kharif (Jun–Sep)',  'suitability' => 'Good',      'water' => 'Moderate'];
        }

        if ($ph < 6.5 && $moisture < 45) {
            $crops[] = ['name' => 'Groundnut', 'season' => 'Kharif (Jun–Sep)',  'suitability' => 'Good',      'water' => 'Low'];
            $crops[] = ['name' => 'Millet',    'season' => 'Kharif (Jun–Sep)',  'suitability' => 'Excellent', 'water' => 'Very Low'];
        }

        if ($ph >= 6.5 && $ph <= 8 && $k >= 50) {
            $crops[] = ['name' => 'Cotton',    'season' => 'Kharif (May–Nov)',  'suitability' => 'Good',      'water' => 'Moderate'];
            $crops[] = ['name' => 'Sugarcane', 'season' => 'Year-round',        'suitability' => 'Good',      'water' => 'Very High'];
        }

        if ($ph >= 5.5 && $ph <= 7 && $n >= 50) {
            $crops[] = ['name' => 'Vegetables (Mixed)', 'season' => 'Year-round', 'suitability' => 'Excellent', 'water' => 'Moderate'];
            $crops[] = ['name' => 'Tomato',   'season' => 'Rabi (Oct–Feb)',     'suitability' => 'Good',      'water' => 'Moderate'];
        }

        // Drought-tolerant fallback
        if (empty($crops) || $moisture < 25) {
            $crops[] = ['name' => 'Sorghum (Jowar)',  'season' => 'Kharif',  'suitability' => 'Good',  'water' => 'Low'];
            $crops[] = ['name' => 'Finger Millet',   'season' => 'Kharif',  'suitability' => 'Good',  'water' => 'Very Low'];
        }

        return array_slice(array_unique($crops, SORT_REGULAR), 0, 6);
    }

    // ─── Health score ─────────────────────────────────────────────────────────

    private function calculateHealthScore(
        float $ph, float $n, float $p, float $k,
        float $moisture, float $organicMatter
    ): int {
        $score = 100;

        // pH penalty
        if ($ph < 5.5 || $ph > 8.5)          $score -= 25;
        elseif ($ph < 6.0 || $ph > 8.0)      $score -= 12;
        elseif ($ph < 6.5 || $ph > 7.5)      $score -= 5;

        // Nitrogen
        if ($n < 30)       $score -= 20;
        elseif ($n < 50)   $score -= 10;
        elseif ($n < 70)   $score -= 4;

        // Phosphorus
        if ($p < 25)       $score -= 15;
        elseif ($p < 45)   $score -= 8;

        // Potassium
        if ($k < 30)       $score -= 15;
        elseif ($k < 50)   $score -= 7;

        // Moisture
        if ($moisture < 15 || $moisture > 85)  $score -= 15;
        elseif ($moisture < 25 || $moisture > 75) $score -= 7;

        // Organic matter
        if ($organicMatter < 1)    $score -= 10;
        elseif ($organicMatter < 2) $score -= 5;

        return max(0, min(100, $score));
    }

    private function healthStatus(int $score): string
    {
        if ($score >= 75) return 'Healthy';
        if ($score >= 45) return 'Moderate';
        return 'Poor';
    }

    // ─── Narrative ────────────────────────────────────────────────────────────

    private function soilConditionSummary(
        float $ph, float $n, float $p, float $k,
        float $moisture, float $organicMatter, string $phCategory
    ): string {
        $parts = [];

        $parts[] = "Soil pH is {$ph} ({$phCategory}).";

        if ($n < 40)       $parts[] = "Nitrogen is critically low — immediate fertilisation required.";
        elseif ($n < 60)   $parts[] = "Nitrogen is moderate — top dressing recommended.";
        else               $parts[] = "Nitrogen levels are adequate.";

        if ($p < 30)       $parts[] = "Phosphorus is very low — DAP application essential.";
        elseif ($p < 50)   $parts[] = "Phosphorus is below optimal.";
        else               $parts[] = "Phosphorus is at a healthy level.";

        if ($k < 40)       $parts[] = "Potassium is low — apply MOP or potash.";
        elseif ($k >= 60)  $parts[] = "Potassium is well-supplied.";

        if ($moisture < 25) $parts[] = "Soil moisture is very low — irrigation or mulching recommended.";
        elseif ($moisture > 75) $parts[] = "Soil is overly moist — improve drainage.";
        else                $parts[] = "Moisture level is within the acceptable range.";

        if ($organicMatter < 2) $parts[] = "Organic matter is low — incorporate compost or FYM.";

        return implode(' ', $parts);
    }
}
