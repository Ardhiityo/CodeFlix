<?php

namespace App\Providers;

use App\Services\Interface\MembershipService;
use App\Services\Interface\PlanService;
use Illuminate\Support\ServiceProvider;
use App\Services\Interface\UserDeviceService;
use App\Services\Repository\MembershipRepository;
use App\Services\Repository\PlanRepository;
use App\Services\Repository\UserDeviceRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserDeviceService::class, UserDeviceRepository::class);
        $this->app->bind(PlanService::class, PlanRepository::class);
        $this->app->bind(MembershipService::class, MembershipRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
