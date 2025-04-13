<?php

use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {
    Route::get('/subscribe/plan', [SubscribeController::class, 'showPlans'])
        ->name('subscribe.plan');
});
