<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
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
        return PembelianDetail::with(
            'barang',
            'pembelian',
            'pembelian.gudang',
            'pembelian.matauang',
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
            ->get();
    }
}
