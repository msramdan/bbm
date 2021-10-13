<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateMataUangRequest;
use App\Models\Matauang;
use App\Models\RateMataUang;
use Illuminate\Http\Request;
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

        // return $rateMataUang;
        // die;

        return view('rate-matauang.index', compact('rateMataUang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $matauang = Matauang::get();

        return view('rate-matauang.create', compact('matauang'));
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
        $matauang = Matauang::get();

        $rateMataUang = RateMataUang::with('matauang_asing', 'matauang_default')->findOrFail($id);

        return view('rate-matauang.edit', compact('rateMataUang', 'matauang'));
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
