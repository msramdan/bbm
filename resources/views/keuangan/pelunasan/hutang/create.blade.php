@extends('layouts.dashboard')
@section('title', trans('pelunasan_hutang.title.tambah'))
@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelunasan_hutang_add') }}
        <!-- begin row -->
        <div class="row">
            <form action="{{ route('pelunasan-hutang.store') }}" method="post" id="form_trx">
                @csrf
                @method('post')
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
                            <h4 class="panel-title">{{ trans('pelunasan_hutang.title.tambah') }} - Header</h4>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-4">
                                    <label for="kode" class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        readonly />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal" class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" required
                                        value="{{ date('Y-m-d') }}" id="tanggal" />
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="rate" class="control-label">Rate</label>
                                    <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                        required />
                                    @error('rate')
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
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="kode_pembelian">Kode Pembelian</label>
                                    <select id="kode_pembelian" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($pembelianBelumLunas as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->kode }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('kode_pembelian')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="tgl_pembelian" class="control-label">Tanggal Pembelian</label>
                                    <input type="text" class="form-control" placeholder="Tanggal Pembelian"
                                        id="tgl_pembelian" readonly />
                                    @error('tgl_pembelian')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="supplier" class="control-label">Supplier</label>
                                    <input type="text" class="form-control" placeholder="Supplier" id="supplier"
                                        readonly />
                                    @error('supplier')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="saldo_hutang" class="control-label">Saldo Hutang</label>
                                    <input type="text" class="form-control" placeholder="Saldo Hutang" id="saldo_hutang"
                                        readonly />
                                    @error('saldo_hutang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- end form-group --}}
                            <div class="form-group row">
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="matauang" class="control-label">Mata Uang</label>
                                    <input type="text" class="form-control" placeholder="Mata Uang" id="matauang"
                                        readonly />
                                    @error('matauang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- Jenis Pembayaran --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label class="control-label">Jenis Pembayaran</label>
                                    <select id="jenis_pembayaran" class="form-control" required>
                                        @forelse ($jenisPembayaran as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('jenis_pembayaran')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label class="control-label">Bank</label>
                                    <select id="bank" class="form-control" disabled>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($bank as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('bank')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label class="control-label">Rekening</label>
                                    <select id="rekening" class="form-control" disabled>
                                        <option value="" disabled selected>-- Pilih Bank Terlebih Dahulu --</option>
                                    </select>
                                    @error('rekening')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            {{-- end form-group --}}
                            <div class="form-group row">
                                <div class="col-md-8">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea id="keterangan" class="form-control" required placeholder="Keterangan"
                                        rows="9"></textarea>
                                    @error('keterangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        {{-- No. Cek/Giro --}}
                                        <div class="col-md-12" style="margin-bottom: 1em;">
                                            <label for="no_cek_giro">No. Cek/Giro </label>
                                            <input type="number" step="any" id="no_cek_giro" class="form-control"
                                                placeholder="No. Cek/Giro " disabled />
                                            @error('no_cek_giro')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- Tgl. Cek/Giro --}}
                                        <div class="col-md-12" style="margin-bottom: 1em;">
                                            <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                            <input type="date" id="tgl_cek_giro" class="form-control"
                                                placeholder="Tgl. Cek/Giro" disabled />
                                            @error('tgl_cek_giro')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        {{-- Bayar --}}
                                        <div class="col-md-12" style="margin-bottom: 1em;">
                                            <label for="bayar">Bayar</label>
                                            <input type="number" step="any" id="bayar" class="form-control" required
                                                placeholder="Bayar" />
                                            @error('bayar')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-bottom: 1em;">
                                    <button type="submit" class="btn btn-primary" id="btn_add">
                                        <i class="fa fa-plus"></i>
                                        Add
                                    </button>
                                    <button type="button" class="btn btn-warning">
                                        <i class="fa fa-times"></i>
                                        Clear Form
                                    </button>
                                </div>
                            </div>
                            {{-- end form-group --}}
                            <hr style="margin: 4px;">
                            <table class="table table-striped table-condensed" id="tbl_trx">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode PMB</th>
                                        <th>Tgl PMB</th>
                                        <th>Supplier</th>
                                        <th>Matauang</th>
                                        <th>Hutang</th>
                                        <th>Pembayaran</th>
                                        <th>Bayar</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>
                                            PURCH-202111000001
                                            <input type="hidden" class="kode_pembelian" name="kode_pembelian[]">
                                        </td>
                                        <td>
                                            {{ date('d/m/Y') }}
                                            <input type="hidden" class="tgl_pembelian" name="tgl_pembelian[]">
                                        </td>
                                        <td>
                                            Jaja
                                            <input type="hidden" class="supplier" name="supplier[]">
                                        </td>
                                        <td> Rupiah
                                            <input type="hidden" class="matauang" name="matauang[]">
                                        </td>
                                        <td>89,000
                                            <input type="hidden" class="hutang" name="hutang[]">
                                        </td>
                                        <td>
                                            <span>Transfer</span>
                                            <br>
                                            <span>Bank: Bank Central Asia(BCA)</span>
                                            <br>
                                            <span>No. Rek: 098767890677</span>
                                            <input type="hidden" class="jenis_pembayaran" name="jenis_pembayaran[]">
                                            <input type="hidden" class="bank" name="bank[]">
                                            <input type="hidden" class="no_rek" name="no_rek[]">
                                            <input type="hidden" class="no_cek_giro" name="no_cek_giro[]">
                                            <input type="hidden" class="tgl_cek_giro" name="tgl_cek_giro[]">
                                        </td>
                                        <td>89,000
                                            <input type="hidden" class="bayar" name="bayar[]">
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs btn_edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs btn_hapus">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        {{-- end panel-body --}}
                    </div>
                    {{-- panel-inverse --}}
                </div>
                {{-- end col-md-12 --}}
            </form>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection
@include('keuangan.pelunasan.hutang.script.create-js')
