<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMataUangRequest;
use App\Http\Requests\UpdateMataUangRequest;
use App\Models\Matauang;
use RealRashid\SweetAlert\Facades\Alert;

class MatauangController extends Controller
{
    public function index()
    {
        $matauang = Matauang::all();
        return view('matauang.index', compact('matauang'));
    }

    public function create()
    {
        return view('matauang.create');
    }

    public function store(StoreMataUangRequest $request)
    {
        Matauang::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('matauang.index');
    }

    public function edit($id)
    {
        $matauang = Matauang::findOrFail($id);

        return view('matauang.edit', compact('matauang'));
    }

    public function update(UpdateMataUangRequest $request, Matauang $matauang)
    {
        $matauang->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('matauang.index');
    }

    public function destroy($id)
    {
        Matauang::findOrFail($id)->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('matauang.index');
    }
}
