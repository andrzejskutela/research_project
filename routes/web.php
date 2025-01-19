<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ResearchController;

Route::controller(LandingController::class)->group(function() {
    Route::get('/', 'welcome');
});

Route::controller(ResearchController::class)->group(function() {
    Route::get('/new-participant', 'start')->name('new_participant');
    Route::get('/info-form', 'infoForm')->name('info_form');
    Route::get('/experiment', 'experiment')->name('experiment');
    Route::get('/test-explanation', 'explanation')->name('explanation');
    Route::get('/memory-test', 'memoryTest')->name('memory_test');
    Route::get('/final', 'final')->name('final');
});
