<?php

use App\Http\Controllers\Akun\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MasterData\{AreaController, BankController, BarangController, GudangController, KategoriController, MatauangController, PelangganController, RateMataUangController, RekeningBankController, SalesmanController, SupplierController, SatuanBarangController};
use App\Http\Controllers\Inventory\{AdjustmentMinusController, AdjustmentPlusController, PerakitanPaketController};
use App\Http\Controllers\Pembelian\{PembelianController, ReturPembelianController, PesananPembelianController};
use App\Http\Controllers\Penjualan\{PenjualanController, ReturPenjualanController};
use App\Http\Controllers\Setting\{TokoController, UserController};
use App\Http\Controllers\Keuangan\{BiayaController, CekGiroCairController, CekGiroTolakController, PelunasanHutangController, PelunasanPiutangController};
use App\Http\Controllers\Laporan\AdjustmentMinusReportController;
use App\Http\Controllers\Laporan\AdjustmentPlusReportController;
use App\Http\Controllers\Laporan\PelunasanHutangReportController;
use App\Http\Controllers\Laporan\PelunasanPiutangReportController;
use App\Http\Controllers\Laporan\PembelianReportController;
use App\Http\Controllers\Laporan\PenjualanReportController;
use App\Http\Controllers\Laporan\PesananPembelianReportController;
use App\Http\Controllers\Laporan\ReturPembelianReportController;
use App\Http\Controllers\Laporan\ReturPenjualanReportController;
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

    Route::get('/barang/cek-stok/{id}', [BarangController::class, 'cekStok']);
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
    Route::post('/perakitan-paket/store', [PerakitanPaketController::class, 'store'])->name('perakitan-paket.store');
    Route::put('/perakitan-paket/update/{id}', [PerakitanPaketController::class, 'update'])->name('perakitan-paket.update');
    Route::get('/perakitan-paket/generate-kode/{tanggal}', [PerakitanPaketController::class, 'generateKode'])->name('perakitan-paket.generateKode');
    Route::resource('/perakitan-paket', PerakitanPaketController::class)->except('store', 'update');
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

// Setting
Route::group(['prefix' => 'setting', 'middleware' => ['web', 'auth']], function () {
    Route::get('/toko', [TokoController::class, 'index'])->name('toko.index')->middleware('permission:toko');
    Route::put('/toko/{toko:id}', [TokoController::class, 'update'])->name('toko.update')->middleware('permission:toko');

    Route::resource('/user', UserController::class)->except('show');
});

// Profile
Route::group(['prefix' => 'akun', 'middleware' => ['web', 'auth']], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
});

// Penjualan
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

// Keuangan
Route::group(['prefix' => 'keuangan', 'middleware' => ['web', 'auth']], function () {
    // Pelunasan Hutang
    Route::get('/pelunasan-hutang/get-pembelian-belum-lunas/{id}', [PelunasanHutangController::class, 'getPembelianYgBelumLunas']);
    Route::get('/pelunasan-hutang/generate-kode/{tanggal}', [PelunasanHutangController::class, 'generateKode']);
    Route::resource('/pelunasan-hutang', PelunasanHutangController::class);

    // Pelunasan Piutang
    Route::get('/pelunasan-piutang/get-penjualan-belum-lunas/{id}', [PelunasanPiutangController::class, 'getPenjualanYgBelumLunas']);
    Route::get('/pelunasan-piutang/generate-kode/{tanggal}', [PelunasanPiutangController::class, 'generateKode']);
    Route::resource('/pelunasan-piutang', PelunasanPiutangController::class);

    // Giro Cair
    Route::get('/cek-giro-cair/generate-kode/{tanggal}', [CekGiroCairController::class, 'generateKode']);
    Route::get('/cek-giro-cair/get-cek-giro-by-id/{id}', [CekGiroCairController::class, 'getCekGiroById']);
    Route::resource('/cek-giro-cair', CekGiroCairController::class);

    // Giro Tolak
    Route::get('/cek-giro-tolak/generate-kode/{tanggal}', [CekGiroTolakController::class, 'generateKode']);
    Route::get('/cek-giro-tolak/get-cek-giro-by-id/{id}', [CekGiroTolakController::class, 'getCekGiroById']);
    Route::resource('/cek-giro-tolak', CekGiroTolakController::class);

    // Biaya
    Route::get('/biaya/generate-kode/{tanggal}', [BiayaController::class, 'generateKode']);
    Route::resource('/biaya', BiayaController::class);
});

// Laporan
Route::group(['prefix' => 'laporan', 'middleware' => ['web', 'auth']], function () {
    Route::get('/adjusment-plus/pdf', [AdjustmentPlusReportController::class, 'pdf'])->name('adjustment-plus.pdf');
    Route::get('/adjusment-plus', [AdjustmentPlusReportController::class, 'index'])->name('adjustment-plus.laporan');

    // Adjustment Minus
    Route::get('/adjusment-minus/pdf', [AdjustmentMinusReportController::class, 'pdf'])->name('adjustment-minus.pdf');
    Route::get('/adjusment-minus', [AdjustmentMinusReportController::class, 'index'])->name('adjustment-minus.laporan');

    // Pesanan Pembelian
    Route::get('/pesanan-pembelian/pdf', [PesananPembelianReportController::class, 'pdf'])->name('pesanan-pembelian.pdf');
    Route::get('/pesanan-pembelian', [PesananPembelianReportController::class, 'index'])->name('pesanan-pembelian.laporan');

    // Pembelian
    Route::get('/pembelian/pdf', [PembelianReportController::class, 'pdf'])->name('pembelian.pdf');
    Route::get('/pembelian', [PembelianReportController::class, 'index'])->name('pembelian.laporan');

    // Pembelian Retur
    Route::get('/retur-pembelian/pdf', [ReturPembelianReportController::class, 'pdf'])->name('retur-pembelian.pdf');
    Route::get('/retur-pembelian', [ReturPembelianReportController::class, 'index'])->name('retur-pembelian.laporan');

    // Penjualan
    Route::get('/penjualan/pdf', [PenjualanReportController::class, 'pdf'])->name('penjualan.pdf');
    Route::get('/penjualan', [PenjualanReportController::class, 'index'])->name('penjualan.laporan');

    // Penjualan Retur
    Route::get('/retur-penjualan/pdf', [ReturPenjualanReportController::class, 'pdf'])->name('retur-penjualan.pdf');
    Route::get('/retur-penjualan', [ReturPenjualanReportController::class, 'index'])->name('retur-penjualan.laporan');

    // Pelunasan Hutang
    Route::get('/pelunasan-hutang/pdf', [PelunasanHutangReportController::class, 'pdf'])->name('pelunasan-hutang.pdf');
    Route::get('/pelunasan-hutang', [PelunasanHutangReportController::class, 'index'])->name('pelunasan-hutang.laporan');

    // Pelunasan Piutang
    Route::get('/pelunasan-piutang/pdf', [PelunasanPiutangReportController::class, 'pdf'])->name('pelunasan-piutang.pdf');
    Route::get('/pelunasan-piutang', [PelunasanPiutangReportController::class, 'index'])->name('pelunasan-piutang.laporan');
});
