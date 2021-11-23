@extends('layouts.dashboard')

@section('title', trans('pesanan_pembelian.title.edit'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pesanan_pembelian_edit') }}
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
                        <h4 class="panel-title">{{ trans('pesanan_pembelian.title.tambah') }} - Header</h4>
                    </div>

                    <div class="panel-body">
                        <form action="{{ route('adjustment-plus.store') }}" method="POST">
                            @csrf

                            <div class="form-group row" style="margin-bottom: 10px">
                                <div class="col-md-4">
                                    <label class="control-label">Kode</label>

                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        value="{{ $pesananPembelian->kode }}" required disabled />
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Tanggal</label>

                                    <input type="date" name="tanggal" class="form-control" disabled
                                        value="{{ $pesananPembelian->tanggal->format('Y-m-d') }}" />
                                </div>

                                {{-- Bentuk stok --}}
                                <div class="col-md-4">
                                    <label for="bentuk_kepemilikan">Bentuk Kepemilikan Stok</label>
                                    <select name="bentuk_kepemilikan" id="bentuk_kepemilikan" class="form-control"
                                        required>
                                        <option value="Stok Sendiri"
                                            {{ $pesananPembelian->bentuk_kepemilikan_stok == 'Stok Sendiri' ? 'selected' : '' }}>
                                            Stok Sendiri</option>
                                        <option value="Konsinyasi"
                                            {{ $pesananPembelian->bentuk_kepemilikan_stok == 'Konsinyasi' ? 'selected' : '' }}>
                                            Konsinyasi</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 mt-3">
                                    <label class="control-label">Supplier</label>

                                    <select name="supplier" class="form-control" required>
                                        <option value="" {{ $pesananPembelian->supplier_id == null ? 'selected' : '' }}>
                                            Tanpa Supplier</option>
                                        @forelse ($supplier as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pesananPembelian->supplier_id == $item->id }}>
                                                {{ $item->nama_supplier }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="control-label">Mata Uang</label>

                                    <select name="matauang" id="matauang" class="form-control" disabled>
                                        <option value="{{ $pesananPembelian->matauang_id }}">
                                            {{ $pesananPembelian->matauang->kode . ' - ' . $pesananPembelian->matauang->nama }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="control-label">Rate</label>
                                    <input type="number" step="any" name="rate" class="form-control" placeholder="Rate"
                                        value="{{ $pesananPembelian->rate }}" disabled />
                                </div>
                            </div>

                            <div class="form-group" style="margin-top: 1em;">
                                <label class="control-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="5"
                                    class="form-control">{{ $pesananPembelian->keterangan }}</textarea>
                            </div>
                        </form>
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
                        <h4 class="panel-title">{{ trans('pesanan_pembelian.title.tambah') }} - List</h4>
                    </div>

                    <div class="panel-body">
                        {{-- Form barang --}}
                        <form id="form_trx" method="POST">
                            <div class="row form-group">
                                {{-- barang --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="kode_barang">Nama Barang</label>
                                    <select name="kode_barang" id="kode_barang_input" class="form-control" required>
                                        <option value="" disabled selected>-- Pilih Matauang Terlebih Dahulu --</option>
                                    </select>
                                </div>

                                {{-- Stok --}}
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="stok">Stok</label>
                                    <input type="number" step="any" name="stok" id="stok_input" class="form-control"
                                        disabled placeholder="Stok" />
                                </div>

                                {{-- Harga --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="harga">Harga</label>
                                    <input type="number" step="any" name="harga" id="harga_input" class="form-control"
                                        required placeholder="Harga" />
                                </div>

                                {{-- Qty --}}
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="qty">Qty</label>
                                    <input type="number" step="any" name="qty" id="qty_input" class="form-control"
                                        required placeholder="Qty" />
                                </div>

                                {{-- Diskon% --}}
                                <div class="col-md-2" style="margin-bottom: 1em;">
                                    <label for="diskon_persen_input">Diskon%</label>
                                    <input type="number" step="any" name="diskon_persen_input" id="diskon_persen_input"
                                        class="form-control" placeholder="Diskon%" />
                                </div>

                                {{-- Diskon --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="diskon">Diskon</label>
                                    <input type="number" step="any" name="diskon_input" id="diskon_input"
                                        class="form-control" readonly placeholder="0" />
                                </div>

                                {{-- Gross --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="gross_input">Gross</label>
                                    <input type="number" step="any" name="gross" id="gross_input" class="form-control"
                                        readonly placeholder="0" />
                                </div>

                                {{-- ppn --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="ppn">PPN</label>
                                    <input type="checkbox" id="checkbox_ppn" checked>
                                    <input type="number" step="any" name="ppn" id="ppn_input" class="form-control"
                                        readonly placeholder="0" />
                                </div>

                                {{-- PPH --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="qty">PPH</label>
                                    <input type="checkbox" id="checkbox_pph" checked>
                                    <input type="number" step="any" name="pph" id="pph_input" class="form-control"
                                        readonly placeholder="0" />
                                </div>
                            </div>

                            <div class="row form-group">
                                {{-- Biaya Masuk --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="biaya_masuk">Biaya Masuk</label>
                                    <input type="number" step="any" name="biaya_masuk" id="biaya_masuk_input"
                                        class="form-control" placeholder="Biaya Masuk" />
                                </div>

                                {{-- Clr. Fee --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="clr_fee">Clr. Fee</label>
                                    <input type="number" step="any" name="clr_fee" id="clr_fee_input" class="form-control"
                                        placeholder="Clr. Fee" />
                                </div>

                                {{-- Netto --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label for="netto">Netto</label>
                                    <input type="number" step="any" name="netto" id="netto_input" placeholder="0"
                                        class="form-control" value="0" readonly />
                                </div>

                                {{-- button --}}
                                <div class="col-md-3" style="margin-bottom: 1em;">
                                    <label>Button</label>
                                    <div class="form-control" style="border: none; padding:0">
                                        <input type="hidden" id="index_tr">

                                        <button type="submit" class="btn btn-primary" id="btn_add">
                                            <i class="fa fa-plus"></i> Add
                                        </button>

                                        <button type="button" class="btn btn-info" id="btn_update" style="display: none"
                                            data-index="">
                                            <i class="fa fa-save"></i> Update
                                        </button>

                                        <button type="button" class="btn btn-warning" id="btn_clear_form">
                                            <i class="fa fa-times"></i> Clear Form
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive" style="margin-bottom: 1em;">
                                    <table class="table table-striped table-condensed table-responsive" id="tbl_trx"
                                        width="100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Barang</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Disc%</th>
                                                <th>Disc</th>
                                                <th>Gross</th>
                                                <th>PPN</th>
                                                <th>PPH</th>
                                                <th>B. Msk</th>
                                                <th>Clr. Fee</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pesananPembelian->pesanan_pembelian_detail as $detail)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                                                        <input type="hidden" class="kode_barang_hidden" name="barang[]"
                                                            value="{{ $detail->barang->id }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->harga) }}
                                                        <input type="hidden" class="harga_hidden" name="harga[]"
                                                            value="{{ $detail->harga }}">
                                                    </td>
                                                    <td>
                                                        {{ $detail->qty }}
                                                        <input type="hidden" class="qty_hidden" name="qty[]"
                                                            value="{{ $detail->qty }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->diskon_persen) }}%
                                                        <input type="hidden" class="diskon_persen_hidden"
                                                            name="diskon_persen[]" value="{{ $detail->diskon_persen }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->diskon) }}
                                                        <input type="hidden" class="diskon_hidden" name="diskon[]"
                                                            value="{{ $detail->diskon }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->gross) }}
                                                        <input type="hidden" name="gross[]" class="gross_hidden"
                                                            value="{{ $detail->gross }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->ppn) }}
                                                        <input type="hidden" class="ppn_hidden" name="ppn[]"
                                                            value="{{ $detail->ppn }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->pph) }}
                                                        <input type="hidden" class="pph_hidden" name="pph[]"
                                                            value="{{ $detail->pph }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->biaya_masuk) }}
                                                        <input type="hidden" class="biaya_masuk_hidden" name="biaya_masuk[]"
                                                            value="{{ $detail->biaya_masuk }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->clr_fee) }}
                                                        <input type="hidden" class="clr_fee_hidden" name="clr_fee[]"
                                                            value="{{ $detail->clr_fee }}">
                                                    </td>
                                                    <td>
                                                        {{ number_format($detail->netto) }}
                                                        <input type="hidden" class="netto_hidden" name="netto[]"
                                                            value="{{ $detail->netto }}">
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <div class="row form-group" id="total" style="margin-top: 1em;">
                                    {{-- subtotal --}}
                                    <div class="col-md-4">
                                        <label for="subtotal">Subtotal</label>
                                        <input type="text" step="any" name="subtotal" id="subtotal" class="form-control"
                                            placeholder="0" readonly />
                                    </div>

                                    {{-- Total PPH --}}
                                    <div class="col-md-4">
                                        <label for="total_pph">Total PPH</label>
                                        <input type="text" step="any" name="total_pph" id="total_pph"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total PPN --}}
                                    <div class="col-md-4">
                                        <label for="total_ppn">Total PPN</label>
                                        <input type="text" step="any" name="total_ppn" id="total_ppn"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Diskon --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_diskon">Total Diskon</label>
                                        <input type="text" step="any" name="total_diskon" id="total_diskon"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Biaya Masuk --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_biaya_masuk">Total Biaya Masuk</label>
                                        <input type="text" step="any" name="total_biaya_masuk" id="total_biaya_masuk"
                                            placeholder="0" class="form-control" readonly />
                                    </div>

                                    {{-- Total Gross --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_gross">Total Gross</label>
                                        <input type="text" step="any" name="total_gross" id="total_gross"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Clr. Fee --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_clr_fee">Total Clr. Fee</label>
                                        <input type="text" step="any" name="total_clr_fee" id="total_clr_fee"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    {{-- Total Netto --}}
                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label for="total_netto">Total Netto</label>
                                        <input type="text" step="any" name="total_netto" id="total_netto"
                                            class="form-control" placeholder="0" readonly />
                                    </div>

                                    <div class="col-md-4" style="margin-top: 1em;">
                                        <label>Button</label>
                                        <div class="form-control" style="border: none; padding:0">
                                            <button class="btn btn-success" id="btn_simpan">Simpan</button>

                                            <button class="btn btn-danger" id="btn_clear_table">Batal</button>
                                        </div>
                                    </div>
                                </div>
                                {{-- end row form-group --}}
                            </div>
                            {{-- end col-md-12 --}}
                        </div>
                        {{-- end row --}}
                    </div>
                    {{-- end panel body --}}
                </div>
                <!-- end panel -->
            </div>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection

@include('pembelian.pesanan-pembelian.script.edit-js')
