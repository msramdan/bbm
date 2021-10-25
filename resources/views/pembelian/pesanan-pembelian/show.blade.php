@extends('layouts.dashboard')

@section('title', trans('pesanan_pembelian.title.show'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pesanan_pembelian_show') }}
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
                        <h4 class="panel-title">{{ trans('pesanan_pembelian.title.tambah') }}</h4>
                    </div>
                    <div class="panel-body">
                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-4">
                                    <label class="control-label">Kode</label>
                                    <input type="text" class="form-control" placeholder="Kode" id="kode" required
                                        value="{{ $pesananPembelian->kode }}" readonly />
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Tanggal</label>
                                    <input type="date" class="form-control" readonly
                                        value="{{ $pesananPembelian->tanggal->format('Y-m-d') }}" />
                                </div>

                                {{-- Bentuk stok --}}
                                <div class="col-md-4">
                                    <label for="bentuk_kepemilikan">Bentuk Kepemilikan Stok</label>
                                    <select id="bentuk_kepemilikan" class="form-control" readonly>
                                        <option value="{{ $pesananPembelian->bentuk_kepemilikan_stok }}">
                                            {{ $pesananPembelian->bentuk_kepemilikan_stok }}
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-4 mt-3">
                                    <label class="control-label">Supplier</label>
                                    <select class="form-control" readonly>
                                        <option value="{{ $pesananPembelian->supplier_id }}">
                                            {{ $pesananPembelian->supplier ? $pesananPembelian->supplier->nama_supplier : 'Tanpa Supplier' }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="control-label">Mata Uang</label>
                                    <select id="matauang" class="form-control" readonly>
                                        <option value="{{ $pesananPembelian->matauang_id }}">
                                            {{ $pesananPembelian->matauang->kode . ' - ' . $pesananPembelian->matauang->nama }}
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-4 mt-3">
                                    <label class="control-label">Rate</label>
                                    <input type="number" step="any" name="rate" class="form-control" placeholder="Rate"
                                        value="{{ $pesananPembelian->rate }}" readonly />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Keterangan</label>
                                <textarea name="keterangan" id="keterangan" rows="5" readonly
                                    class="form-control">{{ $pesananPembelian->keterangan }}</textarea>
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
                                                <th>Qty</th>
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
                                                $total_qty = 0;
                                                $total_diskon_persen = 0;
                                            @endphp
                                            @foreach ($pesananPembelian->pesanan_pembelian_detail as $detail)
                                                @php
                                                    $total_qty += $detail->qty;
                                                    $total_diskon_persen += $detail->diskon_persen;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->barang->kode }}</td>
                                                    <td>{{ $detail->barang->nama }}</td>
                                                    <td>
                                                        {{ $pesananPembelian->matauang->kode . ' ' . $detail->harga }}
                                                    </td>
                                                    <td>
                                                        {{ $detail->qty }}
                                                    </td>
                                                    <td>
                                                        {{ $detail->diskon_persen . '%' }}
                                                    </td>
                                                    <td>
                                                        {{ $pesananPembelian->matauang->kode . ' ' . $detail->diskon }}
                                                    </td>
                                                    <td>
                                                        {{ $pesananPembelian->matauang->kode . ' ' . $detail->gross }}
                                                    </td>
                                                    <td>
                                                        {{ $pesananPembelian->matauang->kode . ' ' . $detail->ppn }}
                                                    </td>
                                                    <td>
                                                        {{ $pesananPembelian->matauang->kode . ' ' . $detail->pph }}
                                                    </td>
                                                    <td>
                                                        {{ $pesananPembelian->matauang->kode . ' ' . $detail->biaya_masuk }}
                                                    </td>
                                                    <td>
                                                        {{ $pesananPembelian->matauang->kode . ' ' . $detail->clr_fee }}
                                                    </td>
                                                    <td>
                                                        {{ $pesananPembelian->matauang->kode . ' ' . $detail->netto }}
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
                                                    {{ $pesananPembelian->matauang->kode . ' ' . $pesananPembelian->subtotal }}
                                                </th>
                                                <th><strong>{{ $total_qty }}</th>
                                                <th>
                                                    {{ $total_diskon_persen . '%' }}
                                                </th>
                                                <th>
                                                    {{ $pesananPembelian->matauang->kode . ' ' . $pesananPembelian->total_diskon }}
                                                </th>
                                                <th>
                                                    {{ $pesananPembelian->matauang->kode . ' ' . $pesananPembelian->total_gross }}
                                                </th>
                                                <th>
                                                    {{ $pesananPembelian->matauang->kode . ' ' . $pesananPembelian->total_ppn }}
                                                </th>
                                                <th>
                                                    {{ $pesananPembelian->matauang->kode . ' ' . $pesananPembelian->total_pph }}
                                                </th>
                                                <th>
                                                    {{ $pesananPembelian->matauang->kode . ' ' . $pesananPembelian->total_biaya_masuk }}
                                                </th>
                                                <th>
                                                    {{ $pesananPembelian->matauang->kode . ' ' . $pesananPembelian->total_clr_fee }}
                                                </th>
                                                <th>
                                                    {{ $pesananPembelian->matauang->kode . ' ' . $pesananPembelian->total_netto }}
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
