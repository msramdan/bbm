<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentMinus;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;

class AdjustmentMinusReportController extends Controller
{
    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.adjustment.minus.index', compact('laporan'));
    }

    public function pdf()
    {
        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.adjustment.minus.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.adjustment_minus') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);

        // kalo pengen langsung download/tanpa priview
        // return $pdf->download($namaFile);
    }

    protected function getLaporan()
    {
        // Optional: ganti make query builder
        return AdjustmentMinus::with(
            'gudang',
            'adjustment_minus_detail',
            'adjustment_minus_detail.barang',
            'adjustment_minus_detail.supplier',
        )
            ->whereHas('adjustment_minus_detail', function ($q) {
                $q->when(request()->query('bentuk_kepemilikan_stok'), function ($q) {
                    $q->where('bentuk_kepemilikan_stok',  request()->query('bentuk_kepemilikan_stok'));
                });

                $q->when(request()->query('barang'), function ($q) {
                    $q->where('barang_id',  request()->query('barang'));
                });
            })
            ->whereHas('adjustment_minus_detail.supplier', function ($q) {
                $q->when(request()->query('supplier'), function ($q) {
                    $q->where('id',  request()->query('supplier'));
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