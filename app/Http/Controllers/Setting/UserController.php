<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\{StoreUserRequest, UpdateUserRequest};
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->get();

        return view('setting.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setting.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        $user->assignRole($request->role);
        $user->givePermissionTo($request->permissions);

        Alert::success('Tambah Data', 'Berhasil');

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('roles', 'permissions');

        return view('setting.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // kalo admin pertama gabisa diedit
        if ($user->id == 1) {
            Alert::success('Update Data', 'Berhasil');

            return redirect()->route('user.index');
        }

        $user->syncRoles($request->role);
        $user->syncPermissions($request->permissions);

        $user->update($request->only(['name', 'email']));

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // kalo admin pertama gabisa diedit
        if ($user->id == 1) {
            Alert::error('Tidak bisa hapus admin', 'Gagal');

            return redirect()->route('user.index');
        }

        $user->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }
}
