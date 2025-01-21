<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ResearchController;

Route::controller(LandingController::class)->group(function() {
    Route::get('/', 'welcome');
});

Route::middleware([App\Http\Middleware\CheckUUID::class])->controller(ResearchController::class)->group(function() {
    Route::get('/new-participant/{uuid}', 'start')->name('new_participant');
    Route::get('/info-form/{uuid}', 'infoForm')->name('info_form');
    Route::get('/experiment/{uuid}', 'experiment')->name('experiment');
    Route::get('/test-explanation/{uuid}', 'explanation')->name('explanation');
    Route::get('/memory-test/{uuid}', 'memoryTest')->name('memory_test');
    Route::get('/final/{uuid}', 'final')->name('final');
});
