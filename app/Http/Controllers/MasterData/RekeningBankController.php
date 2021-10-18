<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreRekeningBankRequest, UpdateRekeningBankRequest};
use App\Models\{Bank, RekeningBank};
use RealRashid\SweetAlert\Facades\Alert;

class RekeningBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rekeningBank = RekeningBank::with('bank')->get();

        return view('master-data.rekening-bank.index', compact('rekeningBank'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::get();

        return view('master-data.rekening-bank.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRekeningBankRequest $request)
    {
        $data = $request->validated();
        $data['bank_id'] = $request->bank;

        RekeningBank::create($data);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('rekening-bank.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RekeningBank  $rekeningBank
     * @return \Illuminate\Http\Response
     */
    public function edit(RekeningBank $rekeningBank)
    {
        $banks = Bank::get();

        $rekeningBank->load('bank');

        return view('master-data.rekening-bank.edit', compact('rekeningBank', 'banks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RekeningBank  $rekeningBank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRekeningBankRequest $request, RekeningBank $rekeningBank)
    {
        $data = $request->validated();
        $data['bank_id'] = $request->bank;

        $rekeningBank->update($data);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('rekening-bank.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RekeningBank  $rekeningBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(RekeningBank $rekeningBank)
    {
        $rekeningBank->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('rekening-bank.index');
    }
}
