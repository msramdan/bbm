@extends('layouts.dashboard')

@section('title', trans('pelunasan_hutang.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelunasan_hutang_edit') }}
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
                                data-click="panel-reload"><i class="fa fa-repeat"></i>
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
                        <h4 class="panel-title">{{ trans('pelunasan_hutang.title.edit') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 1em;">
                            <div class="col-md-3">
                                <label for="kode" class="control-label">Kode</label>
                                <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                    value="{{ $pelunasanHutang->kode }}" readonly />
                                @error('kode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="tanggal" class="control-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ $pelunasanHutang->tanggal->format('Y-m-d') }}" id="tanggal" readonly />
                                @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="rate" class="control-label">Rate</label>
                                <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                    value="{{ $pelunasanHutang->rate }}" readonly />
                                @error('rate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="pembelian">Kode Pembelian</label>
                                <select name="pembelian" id="pembelian" class="form-control" readonly>
                                    <option value="{{ $pelunasanHutang->pembelian_id }}">
                                        {{ $pelunasanHutang->pembelian->kode }}</option>
                                </select>
                                @error('pembelian')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="tgl_pembelian" class="control-label">Tanggal Pembelian</label>
                                <input type="text" name="tgl_pembelian" class="form-control"
                                    placeholder="Tanggal Pembelian" id="tgl_pembelian" readonly
                                    value="{{ $pelunasanHutang->pembelian->tanggal->format('d/m/Y') }}" readonly />
                                @error('tgl_pembelian')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="supplier" class="control-label">Supplier</label>
                                <input type="text" name="supplier" class="form-control" placeholder="Supplier"
                                    id="supplier"
                                    value="{{ $pelunasanHutang->pembelian->supplier ? $pelunasanHutang->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}"
                                    readonly />
                                @error('supplier')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="saldo_hutang" class="control-label">Saldo Hutang</label>
                                <input type="text" name="saldo_hutang" class="form-control" placeholder="Saldo Hutang"
                                    id="saldo_hutang" value="{{ $pelunasanHutang->pembelian->total_netto }}" readonly />
                                @error('saldo_hutang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="matauang" class="control-label">Mata Uang</label>
                                <input type="text" name="matauang" class="form-control" placeholder="Mata Uang"
                                    id="matauang" value="{{ $pelunasanHutang->pembelian->matauang->nama }}" readonly />
                                @error('matauang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->

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
                                data-click="panel-reload"><i class="fa fa-repeat"></i>
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
                        <h4 class="panel-title">{{ trans('pelunasan_hutang.title.payment_list') }}</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 10px">
                            {{-- Jenis Pembayaran --}}
                            <div class="col-md-4">
                                <label class="control-label">Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" readonly>
                                    <option value="{{ $pelunasanHutang->jenis_pembayaran }}">
                                        {{ $pelunasanHutang->jenis_pembayaran }}
                                    </option>
                                </select>
                                @error('jenis_pembayaran')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="control-label">Bank</label>
                                <select name="bank" id="bank" class="form-control" readonly>
                                    <option value="{{ $pelunasanHutang->bank ? $pelunasanHutang->bank->nama : '' }}">
                                        {{ $pelunasanHutang->bank ? $pelunasanHutang->bank->nama : '-' }}
                                    </option>
                                </select>
                                @error('bank')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="control-label">Rekening</label>
                                <select name="rekening" id="rekening" class="form-control" readonly>
                                    <option
                                        value="{{ $pelunasanHutang->rekening_bank ? $pelunasanHutang->rekening_bank->nomor_rekening . ' - ' . $pelunasanHutang->rekening_bank->nama_rekening : '' }}">
                                        {{ $pelunasanHutang->rekening_bank ? $pelunasanHutang->rekening_bank->nomor_rekening . ' - ' . $pelunasanHutang->rekening_bank->nama_rekening : '-' }}
                                    </option>
                                </select>
                                @error('rekening')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- No. Cek/Giro --}}
                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="no_cek_giro">No. Cek/Giro </label>
                                <input type="number" step="any" name="no_cek_giro" id="no_cek_giro" class="form-control"
                                    placeholder="No. Cek/Giro " readonly value="{{ $pelunasanHutang->no_cek_giro }}" />
                                @error('no_cek_giro')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tgl. Cek/Giro --}}
                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                <input type="date" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                    placeholder="Tgl. Cek/Giro" value="{{ $pelunasanHutang->tgl_cek_giro }}" readonly />
                                @error('tgl_cek_giro')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Bayar --}}
                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="bayar">Bayar</label>
                                <input type="number" step="any" name="bayar" id="bayar" class="form-control"
                                    placeholder="Bayar" value="{{ $pelunasanHutang->bayar }}" readonly />
                                @error('bayar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- keterangan --}}
                            <div class="col-md-12" style="margin-top: 1em;">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" readonly
                                    placeholder="Keterangan" rows="5">{{ $pelunasanHutang->keterangan }}</textarea>
                                @error('keterangan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-12" style="margin-top: 1em;">
                                <a href="{{ route('pelunasan-hutang.index') }}"
                                    class="btn btn-sm btn-default">Kembali</a>
                            </div>
                        </div>
                    </div>
                    {{-- end panel-body --}}
                </div>
                {{-- panel-inverse --}}
            </div>
            {{-- end col-md-12 --}}
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
