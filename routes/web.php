<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ResearchController;

Route::controller(LandingController::class)->group(function() {
    Route::get('/', 'welcome');
    Route::get('/init', 'redirectWithNewUUID')->name('redirect_uuid');
    Route::get('/final', 'final')->name('final');
});

Route::middleware([App\Http\Middleware\CheckUUID::class, 'cache.headers:no_store'])->controller(ResearchController::class)->group(function() {
    Route::get('/new-participant/{uuid}', 'newParticipant')->name('new_participant');
    Route::get('/introduction/{uuid}', 'introduction')->name('introduction');
    Route::get('/preparation/{uuid}', 'preparation')->name('preparation');
    Route::get('/memory-task/{uuid}', 'memoryTask')->name('memory_task');
    Route::get('/form/{uuid}', 'form')->name('form');

    Route::post('/register-data/{uuid}', 'registerData')->name('register_data');
    Route::post('/register-form/{uuid}', 'registerForm')->name('register_form');
});
