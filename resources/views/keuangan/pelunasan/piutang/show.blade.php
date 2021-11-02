@extends('layouts.dashboard')

@section('title', trans('pelunasan_piutang.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelunasan_piutang_edit') }}
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
                        <h4 class="panel-title">{{ trans('pelunasan_piutang.title.edit') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 1em;">
                            <div class="col-md-3">
                                <label for="kode" class="control-label">Kode</label>
                                <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                    value="{{ $pelunasanPiutang->kode }}" readonly />
                                @error('kode')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="tanggal" class="control-label">Tanggal</label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="{{ $pelunasanPiutang->tanggal->format('Y-m-d') }}" id="tanggal" readonly />
                                @error('tanggal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="rate" class="control-label">Rate</label>
                                <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                    value="{{ $pelunasanPiutang->rate }}" readonly />
                                @error('rate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="penjualan">Kode Penjualan</label>
                                <select name="penjualan" id="penjualan" class="form-control" readonly>
                                    <option value="{{ $pelunasanPiutang->penjualan_id }}">
                                        {{ $pelunasanPiutang->penjualan->kode }}</option>
                                </select>
                                @error('penjualan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="tgl_penjualan" class="control-label">Tanggal penjualan</label>
                                <input type="text" name="tgl_penjualan" class="form-control"
                                    placeholder="Tanggal penjualan" id="tgl_penjualan" readonly
                                    value="{{ $pelunasanPiutang->penjualan->tanggal->format('d/m/Y') }}" readonly />
                                @error('tgl_penjualan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="pelanggan" class="control-label">pelanggan</label>
                                <input type="text" name="pelanggan" class="form-control" placeholder="pelanggan"
                                    id="pelanggan"
                                    value="{{ $pelunasanPiutang->penjualan->pelanggan ? $pelunasanPiutang->penjualan->pelanggan->nama_pelanggan : 'Tanpa pelanggan' }}"
                                    readonly />
                                @error('pelanggan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="saldo_piutang" class="control-label">Saldo Hutang</label>
                                <input type="text" name="saldo_piutang" class="form-control" placeholder="Saldo Hutang"
                                    id="saldo_piutang" value="{{ $pelunasanPiutang->penjualan->total_netto }}"
                                    readonly />
                                @error('saldo_piutang')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-3">
                                <label for="matauang" class="control-label">Mata Uang</label>
                                <input type="text" name="matauang" class="form-control" placeholder="Mata Uang"
                                    id="matauang" value="{{ $pelunasanPiutang->penjualan->matauang->nama }}" readonly />
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
                        <h4 class="panel-title">{{ trans('pelunasan_piutang.title.payment_list') }}</h4>
                    </div>

                    <div class="panel-body">
                        <div class="form-group row" style="margin-bottom: 10px">
                            {{-- Jenis Pembayaran --}}
                            <div class="col-md-4">
                                <label class="control-label">Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" readonly>
                                    <option value="{{ $pelunasanPiutang->jenis_pembayaran }}">
                                        {{ $pelunasanPiutang->jenis_pembayaran }}
                                    </option>
                                </select>
                                @error('jenis_pembayaran')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label class="control-label">Bank</label>
                                <select name="bank" id="bank" class="form-control" readonly>
                                    <option value="{{ $pelunasanPiutang->bank ? $pelunasanPiutang->bank->nama : '' }}">
                                        {{ $pelunasanPiutang->bank ? $pelunasanPiutang->bank->nama : '-' }}
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
                                        value="{{ $pelunasanPiutang->rekening_bank ? $pelunasanPiutang->rekening_bank->nomor_rekening . ' - ' . $pelunasanPiutang->rekening_bank->nama_rekening : '' }}">
                                        {{ $pelunasanPiutang->rekening_bank ? $pelunasanPiutang->rekening_bank->nomor_rekening . ' - ' . $pelunasanPiutang->rekening_bank->nama_rekening : '-' }}
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
                                    placeholder="No. Cek/Giro " readonly value="{{ $pelunasanPiutang->no_cek_giro }}" />
                                @error('no_cek_giro')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tgl. Cek/Giro --}}
                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                <input type="date" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                    placeholder="Tgl. Cek/Giro" value="{{ $pelunasanPiutang->tgl_cek_giro }}" readonly />
                                @error('tgl_cek_giro')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Bayar --}}
                            <div class="col-md-4" style="margin-top: 1em;">
                                <label for="bayar">Bayar</label>
                                <input type="number" step="any" name="bayar" id="bayar" class="form-control"
                                    placeholder="Bayar" value="{{ $pelunasanPiutang->bayar }}" readonly />
                                @error('bayar')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- keterangan --}}
                            <div class="col-md-12" style="margin-top: 1em;">
                                <label for="keterangan">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" class="form-control" readonly
                                    placeholder="Keterangan" rows="5">{{ $pelunasanPiutang->keterangan }}</textarea>
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
