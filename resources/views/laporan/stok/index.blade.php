@extends('layouts.dashboard')

@section('title', trans('dashboard.laporan.stok_barang'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('laporan_stok_barang') }}
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
                        <h4 class="panel-title">{{ trans('dashboard.laporan.stok_barang') }}</h4>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('stok-barang.laporan') }}" method="GET" style="margin-bottom: 1em;">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-6">
                                    <label for="per_tanggal" class="control-label">Per Tanggal</label>
                                    <input type="date" name="per_tanggal" class="form-control" id="per_tanggal"
                                        value="{{ request()->query('per_tanggal') ? request()->query('per_tanggal') : date('Y-m-d') }}"
                                        required />
                                </div>

                                <div class="col-md-6">
                                    <label for="gudang" class="control-label">Gudang</label>
                                    <select name="gudang" class="form-control" id="gudang">
                                        <option value="" selected>All</option>
                                        @forelse ($gudang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('gudang') && request()->query('gudang') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-6">
                                    <label for="barang" class="control-label">Barang</label>
                                    <select name="barang" class="form-control" id="barang">
                                        <option value="" selected>All</option>
                                        @forelse ($barang as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('barang') && request()->query('barang') == $item->id ? 'selected' : '' }}>
                                                {{ $item->kode . ' - ' . $item->nama }}
                                            </option>
                                        @empty
                                            <option value="" selected disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="bentuk_kepemilikan_stok">Bentuk Kepemilikan Stok</label>
                                    <select name="bentuk_kepemilikan_stok" id="bentuk_kepemilikan_stok"
                                        class="form-control">
                                        <option value="" selected>All</option>
                                        @foreach ($bentukKepemilikanStok as $item)
                                            <option value="{{ $item->id }}"
                                                {{ request()->query('bentuk_kepemilikan_stok') && request()->query('bentuk_kepemilikan_stok') == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa fa-eye"></i> Cek
                            </button>
                            <a href="{{ route('stok-barang.laporan') }}"
                                class="btn btn-sm btn-default{{ request()->query() ? '' : ' disabled' }}">
                                <i class="fa fa-trash"></i> Reset
                            </a>
                            @if (count($laporan) > 0)
                                <a href="{{ route('stok-barang.pdf', request()->query()) }}" target="_blank"
                                    class="btn btn-sm btn-info">
                                    <i class="fa fa-print"></i> Print
                                </a>
                            @endif
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
                                <thead>
                                    <tr>
                                        <th width="15">No.</th>
                                        <th>Barang</th>
                                        <th>Gudang</th>
                                        <th>Qty</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $grandtotal_beli = 0;
                                        $total_qty_beli = 0;
                                        $total_harga_beli = 0;

                                        $grandtotal_jual = 0;
                                        $total_qty_jual = 0;
                                        $total_harga_jual = 0;

                                        $grandtotal_adjustment = 0;
                                        $total_qty_adjustment = 0;
                                        $total_harga_adjustment = 0;

                                        $no = 1;
                                    @endphp
                                    @if (count($laporan) > 0)
                                        @foreach ($laporan['stok_beli'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->pembelian->gudang->nama }}</td>
                                                <td>-{{ $item->qty }}</td>
                                                <td>
                                                    {{-- {{ $item->pembelian->matauang->kode }} --}}
                                                    {{ number_format($item->harga, 2, '.', ',') }}
                                                </td>
                                                <td>
                                                    {{-- {{ $item->pembelian->matauang->kode }} --}}
                                                    {{ number_format($item->gross, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                            @php
                                                $grandtotal_beli += $item->gross;
                                                $total_qty_beli += $item->qty;
                                                $total_harga_beli += $item->harga;
                                            @endphp
                                        @endforeach

                                        @foreach ($laporan['stok_jual'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->penjualan->gudang->nama }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>
                                                    {{-- {{ $item->penjualan->matauang->kode }} --}}
                                                    {{ number_format($item->harga, 2, '.', ',') }}
                                                </td>
                                                <td>
                                                    {{-- {{ $item->penjualan->matauang->kode }} --}}
                                                    {{ number_format($item->gross, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                            @php
                                                $grandtotal_jual += $item->gross;
                                                $total_qty_jual += $item->qty;
                                                $total_harga_jual += $item->harga;
                                            @endphp
                                        @endforeach

                                        @foreach ($laporan['stok_adjustment'] as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                                                <td>{{ $item->adjustment_plus->gudang->nama }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>
                                                    {{-- {{ $item->adjustment_plus->matauang->kode }} --}}
                                                    {{ number_format($item->harga, 2, '.', ',') }}
                                                </td>
                                                <td>
                                                    {{-- {{ $item->adjustment_plus->matauang->kode }} --}}
                                                    {{ number_format($item->subtotal, 2, '.', ',') }}
                                                </td>
                                            </tr>
                                            @php
                                                $grandtotal_adjustment += $item->subtotal;
                                                $total_qty_adjustment += $item->qty;
                                                $total_harga_adjustment += $item->harga;
                                            @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Total</th>
                                        <th>
                                            {{ $total_qty_jual - $total_qty_beli + $total_qty_adjustment }}
                                        </th>
                                        <th>
                                            {{ number_format($total_harga_jual - $total_harga_beli + $total_harga_adjustment, 2, '.', ',') }}
                                        </th>
                                        <th>
                                            {{ number_format($grandtotal_jual - $grandtotal_beli + $grandtotal_adjustment, 2, '.', ',') }}
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end panel -->
            </div>
            <!-- end col-12 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->

    {{-- @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                    </tr> --}}
@endsection
