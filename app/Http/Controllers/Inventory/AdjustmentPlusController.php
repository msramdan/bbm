<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\AdjustmentPlus;
use App\Models\AdjustmentPlusDetail;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\Matauang;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AdjustmentPlusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adjustmentPlus = AdjustmentPlus::with('adjustment_plus_detail')->get();

        return view('inventory.adjustment-plus.index', compact('adjustmentPlus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gudang = Gudang::get();
        $barang = Barang::get();
        $matauang = Matauang::get();
        $supplier = Supplier::get();

        return view('inventory.adjustment-plus.create', compact('gudang', 'barang', 'matauang', 'supplier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $adjusment = '';
        $adjusmentDetail = [];

        DB::transaction(function () use ($request, $adjusmentDetail, $adjusment) {
            $adjusment = AdjustmentPlus::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'matauang_id' => $request->matauang,
                'gudang_id' => $request->gudang,
                'rate' => $request->rate,
                'grand_total' => $request->grand_total,
            ]);

            foreach ($request->barang as $i => $value) {
                $adjusmentDetail[] = new AdjustmentPlusDetail([
                    'barang_id' => $value,
                    'supplier_id' => $request->supplier[$i],
                    'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan[$i],
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'subtotal' => $request->subtotal[$i],
                ]);
            }

            $adjusment->adjustment_plus_detail()->saveMany($adjusmentDetail);
        });

        // Alert::success('Tambah data', 'berhasil');

        // return redirect()->route('adjustment-plus.index');

        return 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function show(AdjustmentPlus $adjustmentPlus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function edit(AdjustmentPlus $adjustmentPlus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AdjustmentPlus $adjustmentPlus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdjustmentPlus $adjustmentPlus)
    {
        //
    }

    // public function simpan(Request $request)
    // {

    // }

    protected function generateKode()
    {
        $checkLatestKode = AdjustmentPlus::whereMonth('tanggal', now()->month)->count();

        if ($checkLatestKode == null) {
            $kode = 'ADJPL-' . date('Ym') . '0000' . 1;
        } else {
            if ($checkLatestKode < 10) {
                $kode = 'ADJPL-' . date('Ym') . '0000' . $checkLatestKode + 1;
            } elseif ($checkLatestKode > 10) {
                $kode = 'ADJPL-' . date('Ym') . '000' . $checkLatestKode + 1;
            } elseif ($checkLatestKode > 100) {
                $kode = 'ADJPL-' . date('Ym') . '00' . $checkLatestKode + 1;
            } elseif ($checkLatestKode > 1000) {
                $kode = 'ADJPL-' . date('Ym') . '0' . $checkLatestKode + 1;
            }
        }

        return $kode;
    }
}
