<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\{PesananPembelian, PesananPembelianDetail, Barang, Gudang, Matauang, Supplier};
use Illuminate\Http\Request;

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
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function show(PesananPembelian $pesananPembelian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(PesananPembelian $pesananPembelian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PesananPembelian $pesananPembelian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PesananPembelian  $pesananPembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(PesananPembelian $pesananPembelian)
    {
        //
    }
}
