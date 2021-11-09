<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade as PDF;

class KomisiReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:laporan komisi salesman');
    }

    public function index()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        return view('laporan.komisi-salesman.index', compact('laporan'));
    }

    public function pdf()
    {
        $laporan = [];

        if (request()->query()) {
            $laporan = $this->getLaporan();
        }

        $toko = $this->getToko();

        $pdf = PDF::loadView('laporan.komisi-salesman.pdf',  compact('laporan', 'toko'))->setPaper('a4', 'potrait');

        $namaFile = trans('dashboard.laporan.komisi_salesman') . ' - ' . date('d F Y') . '.pdf';

        return $pdf->stream($namaFile);
    }

    protected function getLaporan()
    {
        return Penjualan::with(
            'pelanggan:id,nama_pelanggan',
            'matauang:id,kode',
            'salesman:id,nama',
            'pelunasan_piutang',
        )
            ->when(request()->query('salesman'), function ($q) {
                $q->where('salesman_id',  request()->query('salesman'));
            })
            ->whereBetween('tanggal', [
                request()->query('dari_tanggal'),
                request()->query('sampai_tanggal')
            ])
            ->where('status', 'Lunas')
            ->get();
    }
}
