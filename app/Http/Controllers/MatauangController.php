<?php

namespace App\Http\Controllers;

use App\Models\Matauang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MatauangController extends Controller
{
     public function __construct()
    {
        $this->middleware('auth');
    }

     public function index()
    {
        $matauang = Matauang::all();
        return view('matauang.index')->with([
            'matauang' => $matauang
        ]);
    }

    public function create()
    {
        return view('matauang.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Matauang::create($data);
        Alert::success('Tambah Data', 'Berhasil');
        return redirect()->route('matauang.index');
    }

    public function show(Matauang $Matauang)
    {
        //
    }

    public function edit($id)
    {
        $matauang = Matauang::findOrFail($id);
        return view('matauang.edit')->with([
            'matauang' => $matauang,
        ]);
    }

    public function update(Request $request, Matauang $matauang)
    {
        $data = $request->all();
        $matauang = Matauang::findOrFail($matauang->id);
        $matauang->update($data);
        Alert::success('Update Data', 'Berhasil');
        return redirect()->route('matauang.index');
    }

    public function destroy($id)
    {
        $matauang = Matauang::findOrFail($id);
        $matauang ->delete();
        Alert::success('Hapus Data', 'Berhasil');
        return redirect()->route('matauang.index');
    }


}
