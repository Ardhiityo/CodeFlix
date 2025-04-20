<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Production mode
// Schedule::command('app:check-membership')
//     ->daily()
//     ->at('00:00')
//     ->timezone('Asia/Jakarta')
//     ->withoutOverlapping()
//     ->onOneServer()
//     ->evenInMaintenanceMode();

// Development mode
Schedule::command('app:check-membership')->everyMinute();
