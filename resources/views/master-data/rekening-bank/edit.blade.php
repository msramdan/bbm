@extends('layouts.dashboard')

@section('title', trans('rekening_bank.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('rekening_bank_edit') }}

        <!-- begin row -->
        <div class="row">
            <!-- begin col-6 -->
            <div class="col-md-6">
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
                        <h4 class="panel-title">{{ trans('rekening_bank.title.edit') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="{{ route('rekening-bank.update', $rekeningBank->id) }}"
                            method="post" novalidate>
                            @csrf
                            @method('put')

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kode</label>
                                <div class="col-md-9">
                                    <input type="text" name="kode" class="form-control" placeholder="Kode"
                                        value="{{ old('kode') ? old('kode') : $rekeningBank->kode }}" required />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Bank</label>
                                <div class="col-md-9">
                                    <select name="bank" class="form-control" required>
                                        <option value="" selected disabled>-- Pilih --</option>
                                        @forelse ($bank as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $rekeningBank->bank_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="" selected disabled>Data Bank tidak ada</option>
                                        @endforelse
                                    </select>
                                    @error('bank')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Nama Rekening</label>
                                <div class="col-md-9">
                                    <input type="text" name="nama_rekening" class="form-control"
                                        placeholder="Nama Rekening"
                                        value="{{ old('nama_rekening') ? old('nama_rekening') : $rekeningBank->nama_rekening }}"
                                        required />
                                    @error('nama_rekening')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">No. Rekening</label>
                                <div class="col-md-9">
                                    <input type="number" name="nomor_rekening" class="form-control"
                                        placeholder="No. Rekening"
                                        value="{{ old('nomor_rekening') ? old('nomor_rekening') : $rekeningBank->nomor_rekening }}"
                                        required />
                                    @error('nomor_rekening')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Status</label>
                                <div class="col-md-9">
                                    <select name="status" class="form-control" required>
                                        <option value="Y" {{ $rekeningBank->status == 'Y' ? 'selected' : '' }}>Aktif
                                        </option>
                                        <option value="N" {{ $rekeningBank->status == 'N' ? 'selected' : '' }}>No
                                        </option>
                                    </select>
                                    @error('status')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label"></label>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-sm btn-success"> Simpan</button>
                                    <a href="{{ route('rekening-bank.index') }}" class="btn btn-sm btn-default"> Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-6 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
