<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoilReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'image_path',
        'title',
        'ph_level',
        'nitrogen',
        'phosphorus',
        'potassium',
        'moisture',
        'organic_matter',
        'soil_type',
        'soil_ph_category',
        'health_score',
        'health_status',
        'soil_condition',
        'deficiencies',
        'fertilizer_recommendations',
        'crop_recommendations',
        'ai_analysis',
        'ai_soil_type',
        'ai_recommendations',
        'location',
        'temperature',
        'weather_desc',
        'status',
    ];

    protected $casts = [
        'deficiencies'              => 'array',
        'fertilizer_recommendations' => 'array',
        'crop_recommendations'      => 'array',
        'ph_level'                  => 'float',
        'nitrogen'                  => 'float',
        'phosphorus'                => 'float',
        'potassium'                 => 'float',
        'moisture'                  => 'float',
        'organic_matter'            => 'float',
        'health_score'              => 'integer',
        'temperature'               => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine the health status badge CSS class.
     */
    public function getHealthBadgeClass(): string
    {
        return match ($this->health_status) {
            'Healthy'  => 'badge-healthy',
            'Moderate' => 'badge-moderate',
            default    => 'badge-poor',
        };
    }

    /**
     * Determine the score ring color.
     */
    public function getScoreColor(): string
    {
        if ($this->health_score >= 75) return '#34d399';
        if ($this->health_score >= 50) return '#fbbf24';
        return '#f87171';
    }

    /**
     * Get the full URL of the uploaded image.
     */
    public function getImageUrl(): ?string
    {
        return $this->image_path
            ? asset('storage/' . $this->image_path)
            : null;
    }
}
