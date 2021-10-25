<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\SatuanBarangRequest;
use App\Models\SatuanBarang;
use RealRashid\SweetAlert\Facades\Alert;

class SatuanBarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create satuan')->only('create');
        $this->middleware('permission:read satuan')->only('index');
        $this->middleware('permission:edit satuan')->only('edit');
        $this->middleware('permission:update satuan')->only('update');
        $this->middleware('permission:delete satuan')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuanbarang = SatuanBarang::all();
        return view('master-data.satuan-barang.index', compact('satuanbarang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.satuan-barang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SatuanBarangRequest $request)
    {
        SatuanBarang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('satuan-barang.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SatuanBarang  $satuanBarang
     * @return \Illuminate\Http\Response
     */
    public function show(SatuanBarang $satuanBarang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SatuanBarang  $satuanBarang
     * @return \Illuminate\Http\Response
     */
    public function edit(SatuanBarang $satuanBarang)
    {
        $satuanbarang = SatuanBarang::findOrFail($satuanBarang->id);

        return view('master-data.satuan-barang.edit', compact('satuanbarang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SatuanBarang  $satuanBarang
     * @return \Illuminate\Http\Response
     */
    public function update(SatuanBarangRequest $request, SatuanBarang $satuanBarang)
    {
        $satuanBarang->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('satuan-barang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SatuanBarang  $satuanBarang
     * @return \Illuminate\Http\Response
     */
    public function destroy(SatuanBarang $satuanBarang)
    {
        SatuanBarang::findOrFail($satuanBarang->id)->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('satuan-barang.index');
    }
}
