@extends('layouts.dashboard')

@section('title', trans('user.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('user_edit') }}

        <!-- begin row -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse" data-sortable-id="form-stuff-1">
                    <div class="panel-heading">
                        <div class="panel-heading-btn">
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                                data-click="panel-expand">
                                <i class="fa fa-expand"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                                data-click="panel-reload">
                                <i class="fa fa-repeat"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                                data-click="panel-collapse">
                                <i class="fa fa-minus"></i>
                            </a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                                data-click="panel-remove">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                        <h4 class="panel-title">{{ trans('user.title.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('user.update', $user->id) }}" method="post"
                            novalidate>
                            @csrf
                            @method('put')

                            <div class="row form-group" style="margin-bottom: 1em;">
                                <div class="col-md-4">
                                    <label class="control-label">Nama</label>
                                    <input type="text" name="name" class="form-control" placeholder="name"
                                        value="{{ old('name') ? old('name') : $user->name }}" required />
                                    @error('name')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="email"
                                        value="{{ old('email') ? old('email') : $user->email }}" required />
                                    @error('email')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Role</label>
                                    <select name="role" class="form-control" required>
                                        @foreach ($roles as $role)
                                            <option {{ $user->roles[0]->id == $role->id ? 'selected' : '' }}
                                                value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            {{-- Master data --}}
                            <div class="row" style="margin-bottom: 1em;">
                                <div class="col-md-12">
                                    <h3>Master Data
                                        @error('permissions')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </h3>
                                </div>

                                {{-- Mata Uang --}}
                                <div class="col-md-3">
                                    <strong>Mata Uang</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'matauang') && !Str::contains($permission->name, 'rate'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- rate matauang --}}
                                <div class="col-md-3">
                                    <strong>Rate Mata Uang</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'rate'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- bank --}}
                                <div class="col-md-3">
                                    <strong>Bank</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'bank'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- rekening --}}
                                <div class="col-md-3">
                                    <strong>Rekening</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'rekening'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 1em;">
                                {{-- supplier --}}
                                <div class="col-md-3">
                                    <strong>Supplier</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'supplier'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- area --}}
                                <div class="col-md-3">
                                    <strong>Area</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'area'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- pelanggan --}}
                                <div class="col-md-3">
                                    <strong>Pelanggan</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'pelanggan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- salesman --}}
                                <div class="col-md-3">
                                    <strong>Salesman</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'salesman') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="row" style="margin-bottom: 1em;">
                                {{-- gudang --}}
                                <div class="col-md-3">
                                    <strong>Gudang</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'gudang'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- satuan --}}
                                <div class="col-md-3">
                                    <strong>Satuan</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'satuan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- kategori --}}
                                <div class="col-md-3">
                                    <strong>Kategori</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'kategori'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- barang --}}
                                <div class="col-md-3">
                                    <strong>Barang</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'barang') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            {{-- Inventory --}}
                            <div class="row justify-conter-center" style="margin-bottom: 1em;">
                                <div class="col-md-12">
                                    <h3>Inventory</h3>
                                </div>

                                {{-- adjustment plus --}}
                                <div class="col-md-4">
                                    <strong>Adjustment Plus</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'adjustment plus') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- adjustment minus --}}
                                <div class="col-md-4">
                                    <strong>Adjustment Minus</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'adjustment minus') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- perakitan paket --}}
                                <div class="col-md-4">
                                    <strong>Perakitan Paket</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'perakitan paket'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            {{-- Pembelian --}}
                            <div class="row justify-conter-center" style="margin-bottom: 1em;">
                                <div class="col-md-12">
                                    <h3>Pembelian</h3>
                                </div>

                                {{-- pesanan pembelian --}}
                                <div class="col-md-4">
                                    <strong>Pesanan Pembelian</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'pesanan') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- pembelian --}}
                                <div class="col-md-4">
                                    <strong>Pembelian</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'pembelian') && !Str::contains($permission->name, 'retur') && !Str::contains($permission->name, 'pesanan') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- retur --}}
                                <div class="col-md-4">
                                    <strong>Retur</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'retur pembelian') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            {{-- Penjualan & setting --}}
                            <div class="row justify-conter-center" style="margin-bottom: 1em;">
                                <div class="col-md-8">
                                    <h3>Penjualan</h3>
                                </div>

                                <div class="col-md-4">
                                    <h3>Setting</h3>
                                </div>

                                {{-- penjualan --}}
                                <div class="col-md-4">
                                    <strong>Penjualan</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'penjualan') && !Str::contains($permission->name, 'laporan') && !Str::contains($permission->name, 'retur'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- retur penjualan --}}
                                <div class="col-md-4">
                                    <strong>Retur Penjualan</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'retur penjualan') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- toko --}}
                                <div class="col-md-4">
                                    <strong>User dan Toko</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'toko') || Str::contains($permission->name, 'user'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            {{-- keuagan --}}
                            <div class="row justify-conter-center" style="margin-bottom: 1em;">
                                <div class="col-md-12">
                                    <h3>Keuangan</h3>
                                </div>

                                {{-- pelunasan hutang --}}
                                <div class="col-md-3">
                                    <strong>Pelunasan Hutang</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'pelunasan hutang') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- pelunasan piutang --}}
                                <div class="col-md-3">
                                    <strong>Pelunasan Piutang</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'pelunasan piutang') && !Str::contains($permission->name, 'laporan'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                {{-- cek/giro cair --}}
                                <div class="col-md-3">
                                    <strong>Cek/Giro Cair</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'cek/giro cair'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>


                                {{-- cek/giro tolak --}}
                                <div class="col-md-3">
                                    <strong>Cek/Giro Tolak</strong>
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'cek/giro tolak'))
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            {{-- Laporan --}}
                            <div class="row justify-conter-center" style="margin-bottom: 1em;">
                                <div class="col-md-12">
                                    <h3>Laporan</h3>
                                </div>

                                <div class="col-md-3">
                                    {{-- <strong>Laporan</strong> --}}
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'laporan') && $loop->iteration <= 143)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="col-md-3">
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'laporan') && $loop->iteration > 143 && $loop->iteration <= 148)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="col-md-3">
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'laporan') && $loop->iteration > 148 && $loop->iteration < 154)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="col-md-3">
                                    @foreach ($permissions as $permission)
                                        @if (Str::contains($permission->name, 'laporan') && $loop->iteration > 153)
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->name }}"
                                                        {{ $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                    {{ ucwords($permission->name) }}
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-sm btn-success"> Simpan</button>
                                    <a href="{{ route('user.index') }}" class="btn btn-sm btn-default"> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
