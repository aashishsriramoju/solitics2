<?php

namespace App\Http\Controllers;

use App\Models\MarketPrice;
use Illuminate\Http\Request;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $query = MarketPrice::orderBy('price_date', 'desc');

        if ($request->filled('crop')) {
            $query->where('crop_name', 'like', '%' . $request->crop . '%');
        }

        if ($request->filled('state')) {
            $query->where('state', $request->state);
        }

        $prices = $query->paginate(20)->withQueryString();
        $states = MarketPrice::select('state')->distinct()->pluck('state');
        $crops  = MarketPrice::select('crop_name')->distinct()->pluck('crop_name');

        return view('markets.index', compact('prices', 'states', 'crops'));
    }
}
