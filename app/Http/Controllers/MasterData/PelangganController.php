<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StorePelangganRequest, UpdatePelangganRequest};
use App\Models\{Area, Pelanggan};
use RealRashid\SweetAlert\Facades\Alert;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelanggan = Pelanggan::get();

        return view('master-data.pelanggan.index', compact('pelanggan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $area = Area::get();

        return view('master-data.pelanggan.create', compact('area'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePelangganRequest $request)
    {
        $data = $request->validated();
        $data['area_id'] = $request->area;

        Pelanggan::create($data);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('pelanggan.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelanggan $pelanggan)
    {
        $pelanggan->load('area');

        $area = Area::get();

        return view('master-data.pelanggan.edit', compact('area', 'pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
        $data = $request->validated();
        $data['area_id'] = $request->area;

        $pelanggan->update($data);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('pelanggan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelanggan  $pelanggan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('pelanggan.index');
    }
}
