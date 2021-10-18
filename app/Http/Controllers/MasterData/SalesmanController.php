<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreSalesmanRequest, UpdateSalesmanRequest};
use App\Models\Salesman;
use RealRashid\SweetAlert\Facades\Alert;

class SalesmanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $salesman = Salesman::get();

        return view('master-data.salesman.index', compact('salesman'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.salesman.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesmanRequest $request)
    {
        Salesman::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('salesman.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Salesman  $salesman
     * @return \Illuminate\Http\Response
     */
    public function edit(Salesman $salesman)
    {
        return view('master-data.salesman.edit', compact('salesman'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salesman  $salesman
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalesmanRequest $request, Salesman $salesman)
    {
        $salesman->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('salesman.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salesman  $salesman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salesman $salesman)
    {
        $salesman->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('salesman.index');
    }
}