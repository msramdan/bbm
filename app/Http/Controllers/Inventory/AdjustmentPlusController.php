<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\{AdjustmentPlus, AdjustmentPlusDetail, Barang, Gudang, Matauang, Supplier};
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
        $adjustmentPlus = AdjustmentPlus::with('adjustment_plus_detail', 'matauang', 'gudang')->withCount('adjustment_plus_detail')->get();

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
        DB::transaction(function () use ($request) {
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

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adjustmentPlus = AdjustmentPlus::with('adjustment_plus_detail', 'matauang', 'gudang')
            ->withCount('adjustment_plus_detail')
            ->findOrFail($id);

        return view('inventory.adjustment-plus.show', compact('adjustmentPlus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adjustmentPlus = AdjustmentPlus::with('adjustment_plus_detail', 'matauang', 'gudang')
            ->withCount('adjustment_plus_detail')
            ->findOrFail($id);

        $gudang = Gudang::get();
        $barang = Barang::get();
        $supplier = Supplier::get();

        return view('inventory.adjustment-plus.edit', compact('adjustmentPlus', 'gudang', 'barang', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $adjusment = AdjustmentPlus::findOrFail($id);

        DB::transaction(function () use ($request, $adjusment) {
            $adjusment->update([
                'gudang_id' => $request->gudang,
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

            // hapus list barang lama
            $adjusment->adjustment_plus_detail()->delete();

            $adjusment->adjustment_plus_detail()->saveMany($adjusmentDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdjustmentPlus  $adjustmentPlus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adjusment = AdjustmentPlus::findOrFail($id);
        $adjusment->delete();

        Alert::success('Happus Data', 'Berhasil');

        return redirect()->route('adjustment-plus.index');
    }

    protected function generateKode($tanggal)
    {
        if (request()->ajax()) {
            $checkLatestKode = AdjustmentPlus::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->count();

            if ($checkLatestKode == null) {
                $kode = 'ADJPL-' . date('Ym', strtotime($tanggal)) . '0000' . 1;
            } else {
                if ($checkLatestKode < 10) {
                    $kode = 'ADJPL-' . date('Ym', strtotime($tanggal)) . '0000' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 10) {
                    $kode = 'ADJPL-' . date('Ym', strtotime($tanggal)) . '000' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 100) {
                    $kode = 'ADJPL-' . date('Ym', strtotime($tanggal)) . '00' . $checkLatestKode + 1;
                } elseif ($checkLatestKode > 1000) {
                    $kode = 'ADJPL-' . date('Ym', strtotime($tanggal)) . '0' . $checkLatestKode + 1;
                }
            }

            return $kode;
        } else {
            abort(404);
        }
    }
}
