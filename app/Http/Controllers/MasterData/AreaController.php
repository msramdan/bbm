<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;

use App\Http\Requests\{StoreAreaRequest, UpdateAreaRequest};
use App\Models\Area;
use RealRashid\SweetAlert\Facades\Alert;

class AreaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create area')->only('create');
        $this->middleware('permission:read area')->only('index');
        $this->middleware('permission:edit area')->only('edit');
        $this->middleware('permission:update area')->only('update');
        $this->middleware('permission:delete area')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::get();

        return view('master-data.area.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master-data.area.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAreaRequest $request)
    {
        Area::create($request->validated());

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('area.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('master-data.area.edit', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAreaRequest $request, Area $area)
    {
        $area->update($request->validated());

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('area.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        $area->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return redirect()->route('area.index');
    }
}
