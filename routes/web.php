<?php

use App\Http\Controllers\Akun\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MasterData\{AreaController, BankController, BarangController, GudangController, KategoriController, MatauangController, PelangganController, RateMataUangController, RekeningBankController, SalesmanController, SupplierController, SatuanBarangController};
use App\Http\Controllers\Inventory\{AdjustmentMinusController, AdjustmentPlusController};
use App\Http\Controllers\Pembelian\{PembelianController, ReturPembelianController, PesananPembelianController};
use App\Http\Controllers\Penjualan\PenjualanController;
use App\Http\Controllers\Penjualan\ReturPenjualanController;
use App\Http\Controllers\Setting\TokoController;
use App\Http\Controllers\Setting\UserController;
use Illuminate\Support\Facades\Auth;

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
    Route::get('/adjustment-plus/generate-kode/{tanggal}', [AdjustmentPlusController::class, 'generateKode'])->name('adjustment-plus.generateKode');
    Route::resource('/adjustment-plus', AdjustmentPlusController::class)->except('store', 'update');

    // Adjustment Minus
    Route::post('/adjustment-minus/store', [AdjustmentMinusController::class, 'store'])->name('adjustment-minus.store');
    Route::put('/adjustment-minus/update/{id}', [AdjustmentMinusController::class, 'update'])->name('adjustment-minus.update');
    Route::get('/adjustment-minus/generate-kode/{tanggal}', [AdjustmentMinusController::class, 'generateKode'])->name('adjustment-minus.generateKode');
    Route::resource('/adjustment-minus', AdjustmentMinusController::class)->except('store', 'update');

    // Perakitan Paket
    // Coming soon
});

// Pembelian
Route::group(['prefix' => 'beli', 'middleware' => ['web', 'auth']], function () {
    // Pesanan Pembelian
    Route::post('/pesanan-pembelian/store', [PesananPembelianController::class, 'store'])->name('pesanan-pembelian.store');
    Route::put('/pesanan-pembelian/update/{PesananPembelian}', [PesananPembelianController::class, 'update'])->name('pesanan-pembelian.update');
    Route::get('/pesanan-pembelian/generate-kode/{tanggal}', [PesananPembelianController::class, 'generateKode'])->name('pesanan-pembelian.generateKode');
    Route::resource('/pesanan-pembelian', PesananPembelianController::class)->except('store', 'update');


    // Pembelian
    Route::post('/pembelian/store', [PembelianController::class, 'store'])->name('pembelian.store');
    Route::put('/pembelian/update/{PesananPembelian}', [PembelianController::class, 'update'])->name('pembelian.update');
    Route::get('/pembelian/generate-kode/{tanggal}', [PembelianController::class, 'generateKode'])->name('pembelian.generateKode');
    Route::get('/pembelian/get-rekening/{id}', [PembelianController::class, 'getRekeningByBankId'])->name('pembelian.getRekeningByBankId');
    Route::get('/pembelian/get-data-po/{id}', [PembelianController::class, 'getDataPO'])->name('pembelian.getDataPO');
    Route::resource('/pembelian', PembelianController::class)->except('store', 'update');

    // Retur
    Route::post('/retur-pembelian/store', [ReturPembelianController::class, 'store'])->name('retur-pembelian.store');
    Route::put('/retur-pembelian/update/{pembelian_id}', [ReturPembelianController::class, 'update'])->name('retur-pembelian.update');
    Route::get('/retur-pembelian/generate-kode/{tanggal}', [ReturPembelianController::class, 'generateKode'])->name('retur-pembelian.generateKode');
    Route::get('/retur-pembelian/get-pembelian/{id}', [ReturPembelianController::class, 'getPembelianById'])->name('retur-pembelian.getPembelianById');
    Route::resource('/retur-pembelian', ReturPembelianController::class)->except('store', 'update');
});

Route::group(['prefix' => 'setting', 'middleware' => ['web', 'auth']], function () {
    Route::get('/toko', [TokoController::class, 'index'])->name('toko.index')->middleware('permission:toko');
    Route::put('/toko/{toko:id}', [TokoController::class, 'update'])->name('toko.update')->middleware('permission:toko');

    Route::resource('/user', UserController::class)->except('show');
});


Route::group(['prefix' => 'akun', 'middleware' => ['web', 'auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
});


Route::group(['prefix' => 'jual', 'middleware' => ['web', 'auth']], function () {
    // Penjualan
    Route::post('/penjualan/store', [PenjualanController::class, 'store'])->name('penjualan.store');
    Route::put('/penjualan/update/{penjualan:id}', [PenjualanController::class, 'update'])->name('penjualan.update');
    Route::get('/penjualan/generate-kode/{tanggal}', [PenjualanController::class, 'generateKode'])->name('penjualan.generateKode');
    Route::get('/penjualan/get-rekening/{id}', [PenjualanController::class, 'getRekeningByBankId'])->name('penjualan.getRekeningByBankId');
    Route::get('/penjualan/get-alamat/{tanggal}', [PenjualanController::class, 'getAlamatPelanggan'])->name('penjualan.getAlamatPelanggan');
    Route::resource('/penjualan', PenjualanController::class)->except('store', 'update');

    // Retur Penjualan
    Route::post('/retur-penjualan/store', [ReturPenjualanController::class, 'store'])->name('retur-penjualan.store');
    Route::put('/retur-penjualan/update/{returPenjualan:id}', [ReturPenjualanController::class, 'update'])->name('retur-penjualan.update');
    Route::get('/retur-penjualan/generate-kode/{tanggal}', [ReturPenjualanController::class, 'generateKode']);
    Route::get('/retur-penjualan/get-penjualan/{penjualan:id}', [ReturPenjualanController::class, 'getPenjualanById']);
    Route::resource('/retur-penjualan', ReturPenjualanController::class)->except('store', 'update');
});
