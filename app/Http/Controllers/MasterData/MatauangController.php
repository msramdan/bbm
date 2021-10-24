<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreMataUangRequest, UpdateMataUangRequest};
use App\Models\Matauang;
use RealRashid\SweetAlert\Facades\Alert;

class MatauangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create mata uang')->only('create');
        $this->middleware('permission:read mata uang')->only('index');
        $this->middleware('permission:edit mata uang')->only('edit');
        $this->middleware('permission:update mata uang')->only('update');
        $this->middleware('permission:delete mata uang')->only('delete');
    }

    public function index()
    {
        $matauang = Matauang::all();
        return view('master-data.matauang.index', compact('matauang'));
    }

    public function create()
    {
        return view('master-data.matauang.create');
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

        return view('master-data.matauang.edit', compact('matauang'));
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
