<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreBarangRequest, UpdateBarangRequest};
use App\Models\{Barang, Kategori, Matauang, SatuanBarang};
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barang = Barang::with('kategori', 'satuan', 'matauang_beli', 'mata_uang_jual')->get();

        return view('barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::get();
        $satuan = SatuanBarang::get();
        $matauang = Matauang::get();

        return view('barang.create', compact('kategori', 'satuan', 'matauang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarangRequest $request)
    {
        Barang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('barang.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function edit(Barang $barang)
    {
        $kategori = Kategori::get();
        $satuan = SatuanBarang::get();
        $matauang = Matauang::get();

        $barang->load('kategori', 'satuan', 'matauang_beli', 'mata_uang_jual');

        return view('barang.edit', compact('kategori', 'satuan', 'matauang', 'barang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        Barang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('barang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Barang $barang)
    {
        $barang->delete();

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('barang.index');
    }
}
