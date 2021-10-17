<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AreaController, BankController, BarangController, DashboardController, GudangController, KategoriController, LocalizationController, MatauangController, PelangganController, RateMataUangController, RekeningBankController, SalesmanController, SupplierController, SatuanBarangController};
use App\Http\Controllers\Inventory\{AdjustmentMinusController, AdjustmentPlusController};

Route::get('/', [DashboardController::class, 'index']);

//route switch bahasa
Route::get('/localization/{language}', [LocalizationController::class, 'switch'])->name('localization.switch');

// untuk false atw nonaktifkan route register
Auth::routes(['register' => false]);

Route::group(['prefix' => 'dashboard', 'middleware' => ['web', 'auth']], function () {
    //Route Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
});

// group master data
Route::group(['prefix' => 'masterdata', 'middleware' => ['web', 'auth']], function () {
    Route::resource('/matauang', MatauangController::class)->except('show');
    Route::resource('/rate-matauang', RateMataUangController::class)->except('show');
    Route::resource('/bank', BankController::class)->except('show');
    Route::resource('/rekening-bank', RekeningBankController::class)->except('show');
    Route::resource('/supplier', SupplierController::class)->except('show');
    Route::resource('/area', AreaController::class)->except('show');
    Route::resource('/satuan-barang', SatuanBarangController::class)->except('show');
    Route::resource('/pelanggan', PelangganController::class)->except('show');
    Route::resource('/salesman', SalesmanController::class)->except('show');
    Route::resource('/gudang', GudangController::class)->except('show');
    Route::resource('/kategori', KategoriController::class)->except('show');
    Route::resource('/barang', BarangController::class)->except('show');
});

// Inventory
Route::group(['prefix' => 'inventory', 'middleware' => ['web', 'auth']], function () {
    // Adjustment Plus
    Route::post('/adjustment-plus/store', [AdjustmentPlusController::class, 'store'])->name('adjustment-plus.store');
    Route::put('/adjustment-plus/update/{id}', [AdjustmentPlusController::class, 'update'])->name('adjustment-plus.update');
    Route::get('/adjustment-plus/generate-kode', [AdjustmentPlusController::class, 'generateKode'])->name('adjustment-plus.generateKode');
    Route::resource('/adjustment-plus', AdjustmentPlusController::class)->except('store', 'update');

    // Adjustment Minus
    Route::post('/adjustment-minus/store', [AdjustmentMinusController::class, 'store'])->name('adjustment-minus.store');
    Route::put('/adjustment-minus/update/{id}', [AdjustmentMinusController::class, 'update'])->name('adjustment-minus.update');
    Route::get('/adjustment-minus/generate-kode', [AdjustmentMinusController::class, 'generateKode'])->name('adjustment-minus.generateKode');
    Route::resource('/adjustment-minus', AdjustmentMinusController::class)->except('store', 'update');
});
