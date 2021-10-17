<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGudangRequest;
use App\Http\Requests\UpdateGudangRequest;
use App\Models\Gudang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class GudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gudang = Gudang::get();

        return view('master-data.gudang.index', compact('gudang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.gudang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGudangRequest $request)
    {
        Gudang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('gudang.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function edit(Gudang $gudang)
    {
        return view('master-data.gudang.edit', compact('gudang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGudangRequest $request, Gudang $gudang)
    {
        $gudang->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('gudang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gudang  $gudang
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gudang $gudang)
    {
        $gudang->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('gudang.index');
    }
}
