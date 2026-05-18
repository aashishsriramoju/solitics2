<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = 'en';

        if (Auth::check() && Auth::user()->preferred_language) {
            $locale = Auth::user()->preferred_language;
            session(['locale' => $locale]);
        } elseif (session()->has('locale')) {
            $locale = session('locale');
        }

        App::setLocale($locale);

        return $next($request);
    }
}
