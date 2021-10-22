<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreBarangRequest, UpdateBarangRequest};
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;
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

        return view('master-data.barang.index', compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.barang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBarangRequest $request)
    {
        $data = $request->validated();
        $data['gambar'] = 'noimage.png';
        $data['kategori_id'] = $request->kategori;
        $data['satuan_id'] = $request->satuan;

        if ($request->has('gambar') && $request->file('gambar')->isValid()) {
            $filename = time() . '.' . $request->gambar->extension();

            $request->gambar->storeAs('public/img/barang/', $filename);

            $data['gambar'] = $filename;
        }

        Barang::create($data);

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
        $barang->load('kategori', 'satuan', 'matauang_beli', 'mata_uang_jual');

        return view('master-data.barang.edit', compact('barang'));
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
        $data = $request->validated();
        $data['kategori_id'] = $request->kategori;
        $data['satuan_id'] = $request->satuan;

        if ($request->has('gambar') && $request->file('gambar')->isValid()) {
            $filename = time()  . '.' . $request->gambar->extension();

            $request->gambar->storeAs('public/img/barang/', $filename);

            // hapus gambar lama jika bukan gambar default
            if ($barang->gambar != 'noimage.png') {
                Storage::delete('public/img/barang/' . $barang->gambar);
            }

            $data['gambar'] = $filename;
        }

        $barang->update($data);

        Alert::success('Update Data', 'Berhasil');

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
        // hapus gambar lama jika bukan gambar default
        if ($barang->gambar != 'noimage.png') {
            Storage::delete('public/img/barang/' . $barang->gambar);
        }

        $barang->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('barang.index');
    }
}
