<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade as PDF;

class PenjualanReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan penjualan');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.penjualan.penjualan.index', compact('laporan'));
    }

    public function pdf()
    {
        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.penjualan.penjualan.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.penjualan') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return Penjualan::with('penjualan_detail', 'gudang', 'pelanggan', 'salesman', 'matauang')
            ->whereHas('penjualan_detail', function ($q) {
                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
                });
            })
            ->whereHas('penjualan_detail.barang', function ($q) {
                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->whereHas('pelanggan', function ($q) {
                $q->when(request()->query('pelanggan'), function ($q) {
                    $q->where('id',  request()->query('pelanggan'));
                });
            })
            ->whereHas('salesman', function ($q) {
                $q->when(request()->query('salesman'), function ($q) {
                    $q->where('id',  request()->query('salesman'));
                });
            })
            ->whereHas('gudang', function ($q) {
                $q->when(request()->query('gudang'), function ($q) {
                    $q->where('id',  request()->query('gudang'));
                });
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->get();
    }
}
