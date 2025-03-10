<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ResearchController;
use App\Http\Controllers\AdminDashboardController;

use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::middleware('guest')->group(function () {
    Route::get('admin-login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('admin-login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::get('/admin-logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/admin-dashboard', [AdminDashboardController::class, 'dashboard'])->name('admin');
    Route::post('/admin-new-group', [AdminDashboardController::class, 'newGroup'])->name('register_new_group');
    Route::get('/group/{code}', [AdminDashboardController::class, 'startGroup'])->name('start_new_group');
    Route::get('/group/{code}/instructions', [AdminDashboardController::class, 'groupInstructions'])->name('group_instructions');
    Route::get('/group/{code}/task', [AdminDashboardController::class, 'enableTask'])->name('enable_group_task');
});


Route::controller(LandingController::class)->group(function() {
    Route::get('/', 'welcome')->name('landing_page');
    Route::get('/init', 'redirectWithNewUUID')->name('redirect_uuid');
    Route::get('/init/{code}', 'startFromGroup')->name('start_new_from_group');
    Route::post('/init/{uuid}/check', 'checkProgress')->name('new_group_start_check');
});

Route::middleware([App\Http\Middleware\CheckUUID::class, 'cache.headers:no_store'])->controller(ResearchController::class)->group(function() {
    Route::get('/new-participant/{uuid}', 'newParticipant')->name('new_participant');
    Route::get('/introduction/{uuid}', 'introduction')->name('introduction');
    Route::get('/preparation/{uuid}', 'preparation')->name('preparation');
    Route::get('/memory-task/{uuid}', 'memoryTask')->name('memory_task');
    Route::get('/form/{uuid}', 'form')->name('form');
    Route::get('/final/{uuid}', 'final')->name('final');

    Route::post('/register-data/{uuid}', 'registerData')->name('register_data');
    Route::post('/register-form/{uuid}', 'registerForm')->name('register_form');
});
