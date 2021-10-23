<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\Pembelian;
use App\Models\ReturPembelian;
use App\Models\ReturPembelianDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class ReturPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $retur = ReturPembelian::with('retur_pembelian_detail', 'gudang', 'pembelian')->withCount('retur_pembelian_detail')->get();

        return view('pembelian.retur.index', compact('retur'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pembelian.retur.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $retur = ReturPembelian::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'pembelian_id' => $request->pembelian_id,
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'rate' => $request->rate,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_pph' => floatval($request->total_pph),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_clr_fee' => floatval($request->total_clr_fee),
                'total_biaya_masuk' => floatval($request->total_biaya_masuk),
                'total_netto' => floatval($request->total_netto),
            ]);

            foreach ($request->barang as $i => $value) {
                $returDetail[] = new ReturPembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty_beli' => $request->qty_beli[$i],
                    'qty_retur' => $request->qty_retur[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'biaya_masuk' => floatval($request->biaya_masuk[$i]),
                    'clr_fee' => floatval($request->clr_fee[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'pph' => floatval($request->pph[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);
            }

            $retur->retur_pembelian_detail()->saveMany($returDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPembelian $returPembelian)
    {
        $returPembelian->load('retur_pembelian_detail', 'gudang', 'pembelian')->withCount('retur_pembelian_detail');

        return view('pembelian.retur.show', compact('returPembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPembelian $returPembelian)
    {
        $returPembelian->load('retur_pembelian_detail', 'gudang', 'pembelian')->withCount('retur_pembelian_detail');

        return view('pembelian.retur.edit', compact('returPembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $returPembelian = ReturPembelian::findOrFail($id);

        DB::transaction(function () use ($request, $returPembelian) {
            $returPembelian->update([
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_pph' => floatval($request->total_pph),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_clr_fee' => floatval($request->total_clr_fee),
                'total_biaya_masuk' => floatval($request->total_biaya_masuk),
                'total_netto' => floatval($request->total_netto),
            ]);

            foreach ($request->barang as $i => $value) {
                $returDetail[] = new ReturPembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty_beli' => $request->qty_beli[$i],
                    'qty_retur' => $request->qty_retur[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'biaya_masuk' => floatval($request->biaya_masuk[$i]),
                    'clr_fee' => floatval($request->clr_fee[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'pph' => floatval($request->pph[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);
            }

            $returPembelian->retur_pembelian_detail()->delete();

            $returPembelian->retur_pembelian_detail()->saveMany($returDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturPembelian  $returPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPembelian $returPembelian)
    {
        $returPembelian->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    protected function getPembelianById($id)
    {
        $pembelian = Pembelian::with('supplier', 'matauang', 'pembelian_detail')->findOrFail($id);

        return response()->json($pembelian, 200);
    }

    protected function generateKode($tanggal)
    {
        if (request()->ajax()) {
            $checkLatestKode = ReturPembelian::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->count();

            if ($checkLatestKode == null) {
                $kode = 'PURRT-' . date('Ym', strtotime($tanggal)) . '0000' . 1;
            } else {
                if ($checkLatestKode < 10) {
                    $kode = 'PURRT-' . date('Ym', strtotime($tanggal)) . '0000' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 10) {
                    $kode = 'PURRT-' . date('Ym', strtotime($tanggal)) . '000' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 100) {
                    $kode = 'PURRT-' . date('Ym', strtotime($tanggal)) . '00' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 1000) {
                    $kode = 'PURRT-' . date('Ym', strtotime($tanggal)) . '0' . $checkLatestKode + 1;
                }
            }

            return response()->json($kode, 200);
        } else {
            abort(404);
        }
    }
}
