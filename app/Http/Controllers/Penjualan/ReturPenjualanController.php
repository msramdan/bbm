<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Penjualan;
use App\Models\ReturPenjualan;
use App\Models\ReturPenjualanDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class ReturPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $retur = ReturPenjualan::with('gudang', 'penjualan')->withCount('retur_penjualan_detail');

            return Datatables::of($retur)
                ->addIndexColumn()
                ->addColumn('action', 'penjualan.retur.data-table.action')
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('kode_jual', function ($row) {
                    return $row->penjualan->kode;
                })
                ->addColumn('gudang', function ($row) {
                    return $row->gudang->nama;
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->retur_penjualan_detail_count;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->penjualan->matauang->kode . ' ' . number_format($row->total_netto);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('penjualan.retur.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualan.retur.create');
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
            $retur = ReturPenjualan::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'penjualan_id' => $request->penjualan_id,
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'rate' => $request->rate,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_netto' => floatval($request->total_netto),
            ]);

            foreach ($request->barang as $i => $value) {
                $returDetail[] = new ReturPenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty_beli' => $request->qty_beli[$i],
                    'qty_retur' => $request->qty_retur[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);
            }

            $retur->retur_penjualan_detail()->saveMany($returDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function show(ReturPenjualan $returPenjualan)
    {
        $returPenjualan->load('retur_penjualan_detail', 'gudang', 'penjualan')->withCount('retur_penjualan_detail');

        return view('penjualan.retur.show', compact('returPenjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(ReturPenjualan $returPenjualan)
    {
        $returPenjualan->load('retur_penjualan_detail', 'gudang', 'penjualan')->withCount('retur_penjualan_detail');

        return view('penjualan.retur.edit', compact('returPenjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ReturPenjualan $returPenjualan)
    {
        DB::transaction(function () use ($request, $returPenjualan) {
            $returPenjualan->update([
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'rate' => $request->rate,
                'subtotal' => floatval($request->subtotal),
                'total_ppn' => floatval($request->total_ppn),
                'total_gross' => floatval($request->total_gross),
                'total_diskon' => floatval($request->total_diskon),
                'total_netto' => floatval($request->total_netto),
            ]);

            foreach ($request->barang as $i => $value) {
                $returDetail[] = new ReturPenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty_beli' => $request->qty_beli[$i],
                    'qty_retur' => $request->qty_retur[$i],
                    'diskon_persen' => floatval($request->diskon_persen[$i]),
                    'diskon' => floatval($request->diskon[$i]),
                    'gross' => floatval($request->gross[$i]),
                    'ppn' => floatval($request->ppn[$i]),
                    'netto' => floatval($request->netto[$i]),
                ]);
            }

            $returPenjualan->retur_penjualan_detail()->delete();

            $returPenjualan->retur_penjualan_detail()->saveMany($returDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReturPenjualan  $returPenjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(ReturPenjualan $returPenjualan)
    {
        $returPenjualan->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    protected function getPenjualanById($id)
    {
        // kalo ngakses dari browse
        abort_if(!request()->ajax(), 404);

        $penjualan = Penjualan::with('pelanggan', 'SLSRTman', 'matauang', 'penjualan_detail')->findOrFail($id);

        return response()->json($penjualan, 200);
    }

    protected function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = ReturPenjualan::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'SLSRT-' . date('Ym', strtotime($tanggal)) . '0000' . 1;
        } else {
            // hapus "SLSRT-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'SLSRT-');

            $kode =  'SLSRT-' . intval($onlyNumberKode) + 1;
        }

        return response()->json($kode, 200);
    }
}
