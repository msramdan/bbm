<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\{PesananPembelian, PesananPembelianDetail, Barang, Gudang, Matauang, Supplier};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PesananPembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pesanan = PesananPembelian::with('pesanan_pembelian_detail', 'supplier', 'matauang')->withCount('pesanan_pembelian_detail')->get();

        return view('pembelian.pesanan-pembelian.index', compact('pesanan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = Barang::get();
        $matauang = Matauang::get();
        $supplier = Supplier::get();

        return view('pembelian.pesanan-pembelian.create', compact('barang', 'matauang', 'supplier'));
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
            $pesanan = PesananPembelian::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'matauang_id' => $request->matauang,
                'supplier_id' => $request->supplier,
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
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
                $pesananDetail[] = new PesananPembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
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

            $pesanan->pesanan_pembelian_detail()->saveMany($pesananDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(PesananPembelian $pesananPembelian)
    {
        $pesananPembelian->load('pesanan_pembelian_detail', 'supplier', 'matauang')->withCount('pesanan_pembelian_detail');

        return view('pembelian.pesanan-pembelian.show', compact('pesananPembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(PesananPembelian $pesananPembelian)
    {
        $pesananPembelian->load('pesanan_pembelian_detail', 'supplier', 'matauang')->withCount('pesanan_pembelian_detail');

        $barang = Barang::get();
        $matauang = Matauang::get();
        $supplier = Supplier::get();

        return view('pembelian.pesanan-pembelian.edit', compact('pesananPembelian', 'barang', 'matauang', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pesananPembelian = PesananPembelian::findOrFail($id);

        DB::transaction(function () use ($request, $pesananPembelian) {
            $pesananPembelian->update([
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
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
                $pesananPembelianDetail[] = new PesananPembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
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

            $pesananPembelian->pesanan_pembelian_detail()->delete();

            $pesananPembelian->pesanan_pembelian_detail()->saveMany($pesananPembelianDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(PesananPembelian $pesananPembelian)
    {
        $pesananPembelian->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('pesanan-pembelian.index');
    }

    protected function generateKode($tanggal)
    {
        if (request()->ajax()) {
            $checkLatestKode = PesananPembelian::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->count();

            if ($checkLatestKode == null) {
                $kode = 'PUROR-' . date('Ym', strtotime($tanggal)) . '0000' . 1;
            } else {
                if ($checkLatestKode < 10) {
                    $kode = 'PUROR-' . date('Ym', strtotime($tanggal)) . '0000' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 10) {
                    $kode = 'PUROR-' . date('Ym', strtotime($tanggal)) . '000' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 100) {
                    $kode = 'PUROR-' . date('Ym', strtotime($tanggal)) . '00' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 1000) {
                    $kode = 'PUROR-' . date('Ym', strtotime($tanggal)) . '0' . $checkLatestKode + 1;
                }
            }

            return $kode;
        } else {
            abort(404);
        }
    }
}
