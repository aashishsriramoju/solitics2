<?php

namespace Database\Seeders;

use App\Models\MarketPrice;
use Illuminate\Database\Seeder;

class MarketPriceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['Rice (Paddy)',  'Karimnagar APMC',  'Telangana', 'Karimnagar', 1850, 2100, 1980, 'up',   3.2],
            ['Rice (Paddy)',  'Warangal Market',  'Telangana', 'Warangal',   1800, 2050, 1920, 'stable', 0.0],
            ['Wheat',         'Hyderabad Market', 'Telangana', 'Hyderabad',  2200, 2500, 2350, 'up',   1.8],
            ['Maize',         'Nizamabad APMC',   'Telangana', 'Nizamabad',  1400, 1700, 1550, 'down', -2.1],
            ['Soybean',       'Adilabad Market',  'Telangana', 'Adilabad',   3800, 4200, 4050, 'up',   4.5],
            ['Groundnut',     'Kurnool Market',   'Andhra Pradesh', 'Kurnool', 5200, 5800, 5500, 'up', 2.3],
            ['Cotton (Kapas)','Guntur APMC',      'Andhra Pradesh', 'Guntur',  5800, 6500, 6150, 'stable', 0.0],
            ['Tomato',        'Nagpur APMC',      'Maharashtra', 'Nagpur',    800,  1400, 1100, 'up',  12.5],
            ['Onion',         'Lasalgaon Market', 'Maharashtra', 'Nashik',    900,  1600, 1250, 'down', -5.3],
            ['Potato',        'Agra Market',      'Uttar Pradesh', 'Agra',    600,  1100,  850, 'up',   3.0],
            ['Sugarcane',     'Kolhapur APMC',    'Maharashtra', 'Kolhapur', 2800, 3200, 3050, 'stable', 0.0],
            ['Millet (Jowar)','Solapur Market',   'Maharashtra', 'Solapur',  2500, 2900, 2700, 'up',   1.5],
            ['Turmeric',      'Nizamabad APMC',   'Telangana', 'Nizamabad', 7000, 9500, 8200, 'up',   6.2],
            ['Chilli (Dry)',  'Guntur APMC',      'Andhra Pradesh', 'Guntur', 12000, 18000, 15000, 'up', 8.0],
            ['Garlic',        'Indore Market',    'Madhya Pradesh', 'Indore', 4000, 7000, 5800, 'down', -3.2],
            ['Bajra',         'Bikaner Market',   'Rajasthan', 'Bikaner',    2100, 2500, 2300, 'stable', 0.0],
            ['Moong Dal',     'Jaipur APMC',      'Rajasthan', 'Jaipur',    6500, 7500, 7000, 'up',  2.5],
            ['Mustard',       'Alwar Market',     'Rajasthan', 'Alwar',      5000, 5600, 5300, 'up',  1.2],
        ];

        foreach ($data as $row) {
            MarketPrice::create([
                'crop_name'   => $row[0],
                'market_name' => $row[1],
                'state'       => $row[2],
                'district'    => $row[3],
                'min_price'   => $row[4],
                'max_price'   => $row[5],
                'modal_price' => $row[6],
                'trend'       => $row[7],
                'change_pct'  => $row[8],
                'price_date'  => now()->toDateString(),
                'unit'        => 'Quintal',
            ]);
        }
    }
}
