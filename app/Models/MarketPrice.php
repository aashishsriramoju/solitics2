<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_name',
        'market_name',
        'state',
        'district',
        'min_price',
        'max_price',
        'modal_price',
        'unit',
        'trend',
        'change_pct',
        'price_date',
    ];

    protected $casts = [
        'min_price'   => 'float',
        'max_price'   => 'float',
        'modal_price' => 'float',
        'change_pct'  => 'float',
        'price_date'  => 'date',
    ];

    /**
     * Trend arrow and color class.
     */
    public function getTrendIcon(): string
    {
        return match ($this->trend) {
            'up'   => '↑',
            'down' => '↓',
            default => '→',
        };
    }

    public function getTrendClass(): string
    {
        return match ($this->trend) {
            'up'   => 'price-up',
            'down' => 'price-down',
            default => 'text-slate-400',
        };
    }
}
