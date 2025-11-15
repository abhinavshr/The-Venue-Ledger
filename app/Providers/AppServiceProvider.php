<?php

namespace App\Providers;

use App\Models\CourtSchedule;
use Illuminate\Support\Facades\Gate;
use App\Policies\CourtSchedulePolicy;
use Illuminate\Support\Facades\Route;
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
        // Bind the 'court_schedule' route parameter to the CourtSchedule model
        // This automatically resolves the CourtSchedule model for any route using {court_schedule}
        Route::model('court_schedule', \App\Models\CourtSchedule::class);

        // Bind the CourtSchedulePolicy to the CourtSchedule model for authorization checks
        Gate::policy(CourtSchedule::class, CourtSchedulePolicy::class);
    }
}
