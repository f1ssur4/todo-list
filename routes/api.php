<?php

use App\Http\Controllers\Api\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->group(function () {
	Route::get('dashboard', DashboardController::class)->name('api.dashboard');
});
