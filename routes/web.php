<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;

Route::controller(LandingController::class)->group(function() {
    Route::get('/', 'welcome');
});
