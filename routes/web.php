<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SubscribeController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'user.device.limit'])->group(function () {
    Route::get('/subscribe/plans', [SubscribeController::class, 'showPlans'])
        ->name('subscribe.plan');

    Route::get('/subscribe/checkout/{plan}', [SubscribeController::class, 'checkoutPlan'])
        ->name('subscription.checkout');

    Route::post('/subscribe/process/{plan}', [SubscribeController::class, 'processPlan'])
        ->name('subscription.process');

    Route::get('/', [MovieController::class, 'index'])->name('movie.index');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/movies/{movie:slug}', [MovieController::class, 'show'])->name('movies.show');
});
