<?php


namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\{AdjustmentMinus, AdjustmentMinusDetail, Barang, Gudang, Supplier};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class AdjustmentMinusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adjustmentMinus = AdjustmentMinus::with('adjustment_minus_detail',  'gudang')->withCount('adjustment_minus_detail')->get();

        return view('inventory.adjustment-minus.index', compact('adjustmentMinus'));
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
        $supplier = Supplier::get();

        return view('inventory.adjustment-minus.create', compact('gudang', 'barang', 'supplier'));
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
            $adjusment = AdjustmentMinus::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'gudang_id' => $request->gudang
            ]);

            foreach ($request->barang as $i => $value) {
                $adjusmentDetail[] = new AdjustmentMinusDetail([
                    'barang_id' => $value,
                    'supplier_id' => $request->supplier[$i],
                    'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan[$i],
                    'qty' => $request->qty[$i]
                ]);
            }

            $adjusment->adjustment_minus_detail()->saveMany($adjusmentDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AdjustmentMinus  $adjustmentMinus
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $adjustmentMinus = AdjustmentMinus::with('adjustment_minus_detail', 'gudang')
            ->withCount('adjustment_minus_detail')
            ->findOrFail($id);

        return view('inventory.adjustment-minus.show', compact('adjustmentMinus'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AdjustmentMinus  $adjustmentMinus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adjustmentMinus = AdjustmentMinus::with('adjustment_minus_detail', 'gudang')
            ->withCount('adjustment_minus_detail')
            ->findOrFail($id);

        $gudang = Gudang::get();
        $barang = Barang::get();
        $supplier = Supplier::get();

        return view('inventory.adjustment-minus.edit', compact('adjustmentMinus', 'gudang', 'barang', 'supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AdjustmentMinus  $adjustmentMinus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $adjusment = AdjustmentMinus::findOrFail($id);

        DB::transaction(function () use ($request, $adjusment) {
            $adjusment->update([
                'gudang_id' => $request->gudang
            ]);

            foreach ($request->barang as $i => $value) {
                $adjusmentDetail[] = new AdjustmentMinusDetail([
                    'barang_id' => $value,
                    'supplier_id' => $request->supplier[$i],
                    'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan[$i],
                    'qty' => $request->qty[$i]
                ]);
            }

            // hapus list barang lama
            $adjusment->adjustment_minus_detail()->delete();

            $adjusment->adjustment_minus_detail()->saveMany($adjusmentDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AdjustmentMinus  $adjustmentMinus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adjusment = AdjustmentMinus::findOrFail($id);
        $adjusment->delete();

        Alert::success('Happus Data', 'Berhasil');

        return redirect()->route('adjustment-minus.index');
    }

    protected function generateKode()
    {
        if (request()->ajax()) {
            $checkLatestKode = AdjustmentMinus::whereMonth('tanggal', now()->month)->count();

            if ($checkLatestKode == null) {
                $kode = 'ADJMN-' . date('Ym') . '0000' . 1;
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
        } else {
            abort(404);
        }
    }
}