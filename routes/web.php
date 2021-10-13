<?php

use App\Http\Controllers\BankController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MatauangController;
use App\Http\Controllers\RateMataUangController;

Route::get('/', [DashboardController::class, 'index']);

//route switch bahasa
Route::get(
    '/localization/{language}',
    [\App\Http\Controllers\LocalizationController::class, 'switch']
)->name('localization.switch');

Auth::routes([
    'register' => false // untuk false atw nonaktifkan route register
]);

Route::group(['prefix' => 'dashboard', 'middleware' => ['web', 'auth']], function () {
    //Route Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});

// group master data
Route::group(['prefix' => 'masterdata', 'middleware' => ['web', 'auth']], function () {
    //Route matauang
    Route::resource('/matauang', MatauangController::class)->except('show');

    Route::resource('/rate-matauang', RateMataUangController::class)->except('show');

    Route::resource('/bank', BankController::class)->except('show');
});
