<?php

namespace App\Providers;

use App\Models\{Bank, Barang, Gudang, Kategori, Matauang, Pembelian, PesananPembelian, Salesman, SatuanBarang, Supplier};
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\{Role, Permission};
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
            'pembelian.pembelian.edit',
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
            'pembelian.pembelian.edit',
            'pembelian.retur.create',
            'pembelian.retur.edit'
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


        // list pembelian
        View::composer([
            'pembelian.retur.create',
            'pembelian.retur.edit'
        ], function ($view) {
            return $view->with('pembelian', Pembelian::all());
        });

        // list roles
        View::composer([
            'setting.user.create',
            'setting.user.edit'
        ], function ($view) {
            // dicache biar ga cuma get query ke database cuma sekali aja
            $role = Cache::rememberForever('role', function () {
                return Role::all();
            });

            return $view->with('roles', $role);
        });

        // list permissions
        View::composer([
            'setting.user.create',
            'setting.user.edit'
        ], function ($view) {
            $permissions = Cache::rememberForever('permissions', function () {
                return  Permission::all();
            });

            return $view->with('permissions', $permissions);
        });

        // list salesman
        View::composer([
            'setting.user.create',
            'setting.user.edit'
        ], function ($view) {
            return $view->with('salesman', Salesman::all());
        });

        // list jenisPembayaran
        View::composer([
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
        ], function ($view) {
            $jenisPembayaran = Cache::rememberForever('jenisPembayaran', function () {
                return collect([
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
                ]);
            });

            return $view->with('jenisPembayaran', $jenisPembayaran);
        });
    }
}
