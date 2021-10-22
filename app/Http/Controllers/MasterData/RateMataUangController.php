<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\RateMataUangRequest;
use App\Models\RateMataUang;
use RealRashid\SweetAlert\Facades\Alert;

class RateMataUangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rateMataUang = RateMataUang::with('matauang_asing', 'matauang_default')->get();

        return view('master-data.rate-matauang.index', compact('rateMataUang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.rate-matauang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RateMataUangRequest $request)
    {
        RateMataUang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('rate-matauang.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RateMataUang  $rateMataUang
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rateMataUang = RateMataUang::with('matauang_asing', 'matauang_default')->findOrFail($id);

        return view('master-data.rate-matauang.edit', compact('rateMataUang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RateMataUang  $rateMataUang
     * @return \Illuminate\Http\Response
     */
    public function update(RateMataUangRequest $request, $id)
    {
        RateMataUang::findOrFail($id)->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('rate-matauang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RateMataUang  $rateMataUang
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RateMataUang::findOrFail($id)->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('rate-matauang.index');
    }
}
