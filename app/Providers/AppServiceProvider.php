<?php

namespace App\Providers;

use App\Models\SoilReport;
use App\Policies\SoilReportPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the SoilReport policy
        Gate::policy(SoilReport::class, SoilReportPolicy::class);

        // Force HTTPS in production to prevent mixed-content blocking of Vite CSS/JS
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
