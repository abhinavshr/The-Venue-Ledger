<?php

namespace App\Providers;

use App\Models\CourtSchedule;
use Illuminate\Support\Facades\Gate;
use App\Policies\CourtSchedulePolicy;
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
        Gate::policy(CourtSchedule::class, CourtSchedulePolicy::class);
    }
}
