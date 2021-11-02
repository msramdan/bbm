<?php

namespace App\Providers;

use App\Models\{Area, Bank, Barang, CekGiro, Gudang, Kategori, Matauang, Pelanggan, Pembelian, Penjualan, PesananPembelian, Salesman, SatuanBarang, Supplier};
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
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'inventory.perakitan-paket.create',
            'inventory.perakitan-paket.edit',
            'laporan.adjustment.plus.index',
            'laporan.adjustment.minus.index',
            'laporan.pembelian.pesanan.index',
            'laporan.pembelian.pembelian.index',
        ], function ($view) {
            return $view->with('barang', Barang::where('jenis', 1)->get());
        });

        // 1 =  barang, 2 = paket

        // list paket
        View::composer([
            'inventory.perakitan-paket.create',
            'inventory.perakitan-paket.edit'
        ], function ($view) {
            return $view->with('paket', Barang::where('jenis', 2)->get());
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
            'laporan.adjustment.plus.index',
            'laporan.adjustment.minus.index',
            'laporan.pembelian.pesanan.index',
            'laporan.pembelian.pembelian.index',
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
            'pembelian.retur.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'penjualan.retur.edit',
            'penjualan.retur.create',
            'inventory.perakitan-paket.create',
            'inventory.perakitan-paket.edit',
            'laporan.adjustment.plus.index',
            'laporan.adjustment.minus.index',
            'laporan.pembelian.pembelian.index',
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
            'master-data.barang.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'keuangan.biaya.create',
            'keuangan.biaya.edit'
        ], function ($view) {
            return $view->with('matauang', Matauang::all());
        });


        // list bank
        View::composer([
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
            'master-data.rekening-bank.create',
            'master-data.rekening-bank.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'keuangan.pelunasan.hutang.edit',
            'keuangan.pelunasan.hutang.create',
            'keuangan.pelunasan.piutang.edit',
            'keuangan.pelunasan.piutang.create',
            'keuangan.cek-giro.cair.create',
            'keuangan.cek-giro.cair.edit',
            'keuangan.biaya.create',
            'keuangan.biaya.edit'
        ], function ($view) {
            return $view->with('bank', Bank::all());
        });


        // list pesananPembelian
        View::composer([
            'pembelian.pembelian.create',
            // 'pembelian.pembelian.edit',
        ], function ($view) {
            return $view->with('pesananPembelian', PesananPembelian::all());
        });


        // list penjualan
        View::composer([
            'penjualan.retur.create'
        ], function ($view) {
            return $view->with('penjualan', Penjualan::all());
        });

        // list pembelian belum lunas
        View::composer([
            'keuangan.pelunasan.hutang.edit',
            'keuangan.pelunasan.hutang.create'
        ], function ($view) {
            $pembelianBelumLunas = Pembelian::select(['kode', 'id'])->whereStatus('Belum Lunas')->get();
            return $view->with('pembelianBelumLunas', $pembelianBelumLunas);
        });

        // list penjualan belum dibayar
        View::composer([
            'keuangan.pelunasan.piutang.edit',
            'keuangan.pelunasan.piutang.create'
        ], function ($view) {
            $penjualanBelumLunas = Penjualan::select(['kode', 'id'])->whereStatus('Belum Lunas')->get();
            return $view->with('penjualanBelumLunas', $penjualanBelumLunas);
        });

        // list Pelanggan
        View::composer([
            'penjualan.penjualan.create',
            'penjualan.penjualan.edit',
            'penjualan.retur.create'
        ], function ($view) {
            return $view->with('pelanggan', Pelanggan::all());
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
            'setting.user.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create'
        ], function ($view) {
            return $view->with('salesman', Salesman::all());
        });

        // list area
        View::composer([
            'master-data.pelanggan.create',
            'master-data.pelanggan.edit'
        ], function ($view) {
            return $view->with('area', Area::all());
        });

        // Cek/Giro yang belum dilunas/dibayar
        View::composer([
            'keuangan.cek-giro.cair.create',
            'keuangan.cek-giro.cair.edit',
            'keuangan.cek-giro.tolak.create',
            'keuangan.cek-giro.tolak.edit'
        ], function ($view) {
            $cekGiroBelumLunas = CekGiro::with('pembelian', 'penjualan', 'pembelian.pembelian_pembayaran', 'penjualan.penjualan_pembayaran')
                ->where('status', 'Belum Lunas')
                ->get();

            return $view->with('cekGiroBelumLunas', $cekGiroBelumLunas);
        });

        // list Status PO
        View::composer([
            'laporan.pembelian.pesanan.index'
        ], function ($view) {
            return $view->with(
                'statusPo',
                collect([
                    (object)[
                        'id' => 'Open',
                        'nama' => 'Open'
                    ],
                    (object)[
                        'id' => 'Used',
                        'nama' => 'Used'
                    ],
                    (object)[
                        'id' => 'Cancel',
                        'nama' => 'Cancel'
                    ],
                ])
            );
        });

        // list dicairkan ke
        View::composer([
            'keuangan.cek-giro.cair.create',
            'keuangan.cek-giro.cair.edit',
            'keuangan.biaya.create',
            'keuangan.biaya.edit'
        ], function ($view) {
            return $view->with(
                'dicairkanKe',
                collect([
                    (object)[
                        'id' => 'Kas',
                        'nama' => 'Kas'
                    ],
                    (object)[
                        'id' => 'Bank',
                        'nama' => 'Bank'
                    ],
                ])
            );
        });

        // list jenis transaksi
        View::composer([
            'keuangan.biaya.create',
            'keuangan.biaya.edit'
        ], function ($view) {
            return $view->with(
                'jenisTransaksi',
                collect([
                    (object)[
                        'id' => 'Pemasukan',
                        'nama' => 'Pemasukan'
                    ],
                    (object)[
                        'id' => 'Pengeluaran',
                        'nama' => 'Pengeluaran'
                    ],
                ])
            );
        });

        // list bentuk kepemilikan stok
        View::composer([
            'laporan.adjustment.plus.index',
            'laporan.adjustment.minus.index',
            'laporan.pembelian.pesanan.index',
            'laporan.pembelian.pembelian.index',
        ], function ($view) {
            return $view->with(
                'bentukKepemilikanStok',
                collect([
                    (object)[
                        'id' => 'Stok Sendiri',
                        'nama' => 'Stok Sendiri'
                    ],
                    (object)[
                        'id' => 'Konsinyasi',
                        'nama' => 'Konsinyasi'
                    ],
                ])
            );
        });

        // list jenisPembayaran
        View::composer([
            'pembelian.pembelian.create',
            'pembelian.pembelian.edit',
            'penjualan.penjualan.edit',
            'penjualan.penjualan.create',
            'keuangan.pelunasan.hutang.edit',
            'keuangan.pelunasan.hutang.create',
            'keuangan.pelunasan.piutang.edit',
            'keuangan.pelunasan.piutang.create'
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
