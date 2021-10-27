@extends('layouts.dashboard')

@section('title', trans('retur_pembelian.title.show'))

@section('content')
    @php
    $matauang = $returPembelian->pembelian->matauang;
    @endphp
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('retur_pembelian_show') }}
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
                        <h4 class="panel-title">{{ trans('retur_pembelian.title.show') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-3">
                                    <label class="control-label">Kode</label>
                                    <input type="text" class="form-control" placeholder="Kode" id="kode" required
                                        value="{{ $returPembelian->kode }}" readonly />
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Tanggal</label>
                                    <input type="date" class="form-control" readonly
                                        value="{{ $returPembelian->tanggal->format('Y-m-d') }}" />
                                </div>

                                <div class="col-md-3">
                                    <label for="gudang">Gudang</label>
                                    <select id="gudang" class="form-control" readonly>
                                        <option value="{{ $returPembelian->gudang->id }}">
                                            {{ $returPembelian->gudang->nama }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="pembelian_id">Kode Pembelian</label>
                                    <select id="pembelian_id" class="form-control" readonly>
                                        <option value="{{ $returPembelian->pembelian->id }}">
                                            {{ $returPembelian->pembelian->kode }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-3">
                                    <label class="control-label">Supplier</label>
                                    <select class="form-control" readonly>
                                        <option value="{{ $returPembelian->supplier_id }}">
                                            {{ $returPembelian->supplier ? $data->supplier->nama_supplier : 'Tanpa Supplier' }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Mata Uang</label>
                                    <select id="matauang" class="form-control" readonly>
                                        <option value="{{ $returPembelian->matauang_id }}">
                                            {{ $matauang->kode . ' - ' . $matauang->nama }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="bentuk_kepemilikan">Bentuk Kepemilikan Stok</label>
                                    <select id="bentuk_kepemilikan" class="form-control" readonly>
                                        <option value="{{ $returPembelian->pembelian->bentuk_kepemilikan_stok }}">
                                            {{ $returPembelian->pembelian->bentuk_kepemilikan_stok }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="control-label">Rate</label>
                                    <input type="number" step="any" name="rate" class="form-control" placeholder="Rate"
                                        value="{{ $returPembelian->rate }}" readonly />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="5" readonly
                                    class="form-control">{{ $returPembelian->keterangan }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                </div>

                                {{-- table barang --}}
                                <div class="col-md-12">
                                    <table class="table table-striped table-hover table-condensed" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Harga</th>
                                                <th>Qty Beli</th>
                                                <th>Qty Retur</th>
                                                <th>Disc%</th>
                                                <th>Disc</th>
                                                <th>Gross</th>
                                                <th>PPN</th>
                                                <th>PPH</th>
                                                <th>Biaya Masuk</th>
                                                <th>Clr. Fee</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $total_qty_beli = 0;
                                                $total_qty_retur = 0;
                                                $total_diskon_persen = 0;
                                            @endphp
                                            @foreach ($returPembelian->retur_pembelian_detail as $detail)
                                                @php
                                                    $total_qty_beli += $detail->qty_beli;
                                                    $total_qty_retur += $detail->qty_retur;
                                                    $total_diskon_persen += $detail->diskon_persen;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->barang->kode }}</td>
                                                    <td>{{ $detail->barang->nama }}</td>
                                                    <td>
                                                        {{ $matauang->kode . ' ' . $detail->harga }}
                                                    </td>
                                                    <td>
                                                        {{ $detail->qty_beli }}
                                                    </td>
                                                    <td>
                                                        {{ $detail->qty_retur }}
                                                    </td>
                                                    <td>
                                                        {{ $detail->diskon_persen . '%' }}
                                                    </td>
                                                    <td>
                                                        {{ $matauang->kode . ' ' . $detail->diskon }}
                                                    </td>
                                                    <td>
                                                        {{ $matauang->kode . ' ' . $detail->gross }}
                                                    </td>
                                                    <td>
                                                        {{ $matauang->kode . ' ' . $detail->ppn }}
                                                    </td>
                                                    <td>
                                                        {{ $matauang->kode . ' ' . $detail->pph }}
                                                    </td>
                                                    <td>
                                                        {{ $matauang->kode . ' ' . $detail->biaya_masuk }}
                                                    </td>
                                                    <td>
                                                        {{ $matauang->kode . ' ' . $detail->clr_fee }}
                                                    </td>
                                                    <td>
                                                        {{ $matauang->kode . ' ' . $detail->netto }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="3">
                                                    Total
                                                </th>
                                                <th>
                                                    {{ $matauang->kode . ' ' . $returPembelian->subtotal }}
                                                </th>
                                                <th>{{ $total_qty_beli }}</th>
                                                <th>{{ $total_qty_retur }}</th>
                                                <th>
                                                    {{ $total_diskon_persen . '%' }}
                                                </th>
                                                <th>
                                                    {{ $matauang->kode . ' ' . $returPembelian->total_diskon }}
                                                </th>
                                                <th>
                                                    {{ $matauang->kode . ' ' . $returPembelian->total_gross }}
                                                </th>
                                                <th>
                                                    {{ $matauang->kode . ' ' . $returPembelian->total_ppn }}
                                                </th>
                                                <th>
                                                    {{ $matauang->kode . ' ' . $returPembelian->total_pph }}
                                                </th>
                                                <th>
                                                    {{ $matauang->kode . ' ' . $returPembelian->total_biaya_masuk }}
                                                </th>
                                                <th>
                                                    {{ $matauang->kode . ' ' . $returPembelian->total_clr_fee }}
                                                </th>
                                                <th>
                                                    {{ $matauang->kode . ' ' . $returPembelian->total_netto }}
                                                </th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        {{-- end panel body --}}
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
