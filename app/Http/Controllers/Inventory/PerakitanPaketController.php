<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\PerakitanPaket;
use App\Models\PerakitanPaketDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PerakitanPaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paket = PerakitanPaket::with('perakitan_paket_detail',  'gudang', 'paket')->withCount('perakitan_paket_detail')->orderByDesc('updated_at');

        if (request()->ajax()) {
            return DataTables::of($paket)
                ->addIndexColumn()
                ->addColumn('action', 'inventory.perakitan-paket.data-table.action')
                ->addColumn('gudang', function ($row) {
                    return $row->gudang->nama;
                })
                ->addColumn('paket', function ($row) {
                    return $row->paket->kode . ' - ' . $row->paket->nama;
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->perakitan_paket_detail_count;
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->toJson();
        }

        return view('inventory.perakitan-paket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.perakitan-paket.create');
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
            $paket = PerakitanPaket::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'gudang_id' => $request->gudang,
                'paket_id' => $request->paket,
                'kuantitas' => $request->kuantitas,
                'keterangan' => $request->keterangan
            ]);

            foreach ($request->barang as $i => $value) {
                $paketDetail[] = new PerakitanPaketDetail([
                    'barang_id' => $value,
                    'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan[$i],
                    'qty' => $request->qty[$i]
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok - $request->qty[$i])]);
            }

            $paket->perakitan_paket_detail()->saveMany($paketDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PerakitanPaket  $perakitanPaket
     * @return \Illuminate\Http\Response
     */
    public function show(PerakitanPaket $perakitanPaket)
    {
        $perakitanPaket->load('perakitan_paket_detail',  'gudang', 'paket');

        return view('inventory.perakitan-paket.show', compact('perakitanPaket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PerakitanPaket  $perakitanPaket
     * @return \Illuminate\Http\Response
     */
    public function edit(PerakitanPaket $perakitanPaket)
    {
        $perakitanPaket->load('perakitan_paket_detail',  'gudang', 'paket');

        return view('inventory.perakitan-paket.edit', compact('perakitanPaket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $perakitan = PerakitanPaket::findOrFail($id);

        DB::transaction(function () use ($request, $perakitan) {
            $perakitan->update([
                // 'kode' => $request->kode,
                // 'tanggal' => $request->tanggal,
                'gudang_id' => $request->gudang,
                'paket_id' => $request->paket,
                'kuantitas' => $request->kuantitas,
                'keterangan' => $request->keterangan
            ]);

            foreach ($request->barang as $i => $value) {
                $perakitanDetail[] = new PerakitanPaketDetail([
                    'barang_id' => $value,
                    'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan[$i],
                    'qty' => $request->qty[$i]
                ]);

                // Update stok barang
                $barangQuery = Barang::whereId($value);
                $getBarang = $barangQuery->first();
                $barangQuery->update(['stok' => ($getBarang->stok - $request->qty[$i])]);
            }

            // hapus list barang lama
            $perakitan->perakitan_paket_detail()->delete();

            $perakitan->perakitan_paket_detail()->saveMany($perakitanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PerakitanPaket  $perakitanPaket
     * @return \Illuminate\Http\Response
     */
    public function destroy(PerakitanPaket $perakitanPaket)
    {
        $perakitanPaket->delete();

        Alert::success('Happus Data', 'Berhasil');

        return redirect()->route('perakitan-paket.index');
    }

    public function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = PerakitanPaket::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'PCKASM-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "PCKASM-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'PCKASM-');

            $kode =  'PCKASM-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
