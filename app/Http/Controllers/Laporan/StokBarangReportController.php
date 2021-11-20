<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentPlusDetail;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\PenjualanDetail;
use Barryvdh\DomPDF\Facade as PDF;

class StokBarangReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan stok barang');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        // return $this->getLaporan();
        return view('laporan.stok.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.stok.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.stok_barang') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        // return Barang::select('id', 'nama')->with(
        //     'pembelian_detail:barang_id,id,pembelian_id,qty,harga,gross',
        //     'pembelian_detail.pembelian:id,kode,gudang_id,matauang_id',
        //     'pembelian_detail.pembelian.gudang:id,kode,nama',
        //     'pembelian_detail.pembelian.matauang:id,kode,nama',

        //     'penjualan_detail:barang_id,id,penjualan_id,qty,harga,gross',
        //     'penjualan_detail.penjualan:id,kode,gudang_id',
        //     'penjualan_detail.penjualan.gudang:id,kode,nama',
        //     'penjualan_detail.penjualan.matauang:id,kode,nama',

        //     'adjustment_plus_detail:barang_id,id,adjustment_plus_id,qty,harga,subtotal',
        //     'adjustment_plus_detail.adjustment_plus:id,kode,gudang_id',
        //     'adjustment_plus_detail.adjustment_plus.gudang:id,kode,nama',
        //     'adjustment_plus_detail.adjustment_plus.matauang:id,kode,nama',
        // )
        //     ->when(request()->query('barang'), function ($q) {
        //         $q->whereHas('pembelian_detail', function ($q) {
        //             $q->where('barang_id',  request()->query('barang'));
        //         });

        //         $q->whereHas('adjustment_plus_detail', function ($q) {
        //             $q->where('barang_id',  request()->query('barang'));
        //         });

        //         $q->whereHas('penjualan_detail', function ($q) {
        //             $q->where('barang_id',  request()->query('barang'));
        //         });
        //     })
        //     ->when(request()->query('gudang'), function ($q) {
        //         $q->whereHas('pembelian_detail.pembelian', function ($q) {
        //             $q->where('gudang_id',  request()->query('gudang'));
        //         });

        //         $q->whereHas('penjualan_detail.penjualan', function ($q) {
        //             $q->where('gudang_id',  request()->query('gudang'));
        //         });

        //         $q->whereHas('adjustment_plus_detail.adjustment_plus', function ($q) {
        //             $q->where('gudang_id',  request()->query('gudang'));
        //         });
        //     })
        //     ->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
        //         $q->whereHas('pembelian_detail.pembelian', function ($q) {
        //             $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
        //         });

        //         $q->whereHas('penjualan_detail.penjualan', function ($q) {
        //             $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
        //         });
        //     })
        //     ->get();
        // die;

        $stok_beli = PembelianDetail::select('id', 'qty', 'harga', 'gross', 'barang_id', 'pembelian_id')->with(
            'barang:id,nama,kode',
            'pembelian:id,kode,gudang_id,matauang_id',
            'pembelian.gudang:id,nama',
            // 'pembelian.matauang:id,kode',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('pembelian', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->limit(100)
            ->orderByDesc('pembelian_id')
            ->get();

        $stok_jual = PenjualanDetail::select('id', 'qty', 'harga', 'gross', 'barang_id', 'penjualan_id')->with(
            'barang:id,nama,kode',
            'penjualan:id,kode,gudang_id,matauang_id',
            'penjualan.gudang:id,nama',
            // 'penjualan.matauang:id,kode',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('penjualan', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->limit(100)
            ->orderByDesc('penjualan_id')
            ->get();

        $stok_adjustment = AdjustmentPlusDetail::select('id', 'qty', 'harga', 'subtotal', 'barang_id', 'adjustment_plus_id')->with(
            'barang:id,nama,kode',
            'adjustment_plus:id,kode,gudang_id,matauang_id',
            'adjustment_plus.gudang:id,nama',
            // 'adjustment_plus.matauang:id,kode',
        )
            ->when(request()->query('barang'), function ($q) {
                $q->where('barang_id',  request()->query('barang'));
            })
            ->whereHas('adjustment_plus', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('gudang_id',  request()->query('gudang'));
                });

                $q->when(request()->query('per_tanggal'), function ($q) {
                    $q->where('tanggal', '<=', request()->query('per_tanggal'));
                });

                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok', request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->limit(100)
            ->orderByDesc('adjustment_plus_id')
            ->get();

        return [
            'stok_beli' => $stok_beli,
            'stok_jual' =>  $stok_jual,
            'stok_adjustment' => $stok_adjustment
        ];
    }
}
