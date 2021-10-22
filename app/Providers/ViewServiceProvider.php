<?php

namespace App\Providers;

use App\Models\Bank;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Kategori;
use App\Models\Matauang;
use App\Models\PesananPembelian;
use App\Models\SatuanBarang;
use App\Models\Supplier;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // list barang
        View::composer([
            'inventory.adjustment-plus.create',
            'inventory.adjustment-plus.edit',
            'inventory.adjustment-minus.create',
            'inventory.adjustment-minus.edit',
            'pembelian.pesanan-pembelian.create',
            'pembelian.pesanan-pembelian.edit',
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit'
        ], function ($view) {
            return $view->with('barang', Barang::all());
        });


        // list supplier
        View::composer([
            'inventory.adjustment-plus.create',
            'inventory.adjustment-plus.edit',
            'inventory.adjustment-minus.create',
            'inventory.adjustment-minus.edit',
            'pembelian.pesanan-pembelian.create',
            'pembelian.pesanan-pembelian.edit',
            'pembelian.pembelian.create',
        ], function ($view) {
            return $view->with('supplier', Supplier::all());
        });


        // list gudang
        View::composer([
            'inventory.adjustment-plus.create',
            'inventory.adjustment-plus.edit',
            'inventory.adjustment-minus.create',
            'inventory.adjustment-minus.edit',
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit'
        ], function ($view) {
            return $view->with('gudang', Gudang::all());
        });


        // list matauang
        View::composer([
            'inventory.adjustment-plus.create',
            'pembelian.pesanan-pembelian.create',
            'pembelian.pembelian.create',
            'master-data.rate-matauang.create',
            'master-data.rate-matauang.edit',
            'master-data.barang.create',
            'master-data.barang.edit'
        ], function ($view) {
            return $view->with('matauang', Matauang::all());
        });


        // list bank
        View::composer([
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
            'master-data.rekening-bank.create',
            'master-data.rekening-bank.edit'
        ], function ($view) {
            return $view->with('bank', Bank::all());
        });


        // list pesananPembelian
        View::composer([
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
        ], function ($view) {
            return $view->with('pesananPembelian', PesananPembelian::all());
        });


        // list Kategori
        View::composer([
            'master-data.barang.create',
            'master-data.barang.edit'
        ], function ($view) {
            return $view->with('kategori', Kategori::all());
        });


        // list Satuan
        View::composer([
            'master-data.barang.create',
            'master-data.barang.edit'
        ], function ($view) {
            return $view->with('satuan', SatuanBarang::all());
        });


        // list jenisPembayaran
        View::composer([
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
        ], function ($view) {
            return $view->with('jenisPembayaran', collect([
                (object)  [
                    'id' => 'Cash',
                    'nama' => 'Cash'
                ],
                (object)  [
                    'id' => 'Transfer',
                    'nama' =>  'Transfer',
                ],
                (object) [
                    'id' => 'Giro',
                    'nama' => 'Giro'
                ]
            ]));
        });
    }
}
