@extends('layouts.dashboard')

@section('title', trans('retur_pembelian.title.index'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('retur_pembelian') }}
        <!-- begin row -->
        <div class="row">
            <!-- begin col-12 -->
            <div class="col-md-12">
                <!-- begin panel -->
                <div class="panel panel-inverse">
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
                        <a href="{{ route('retur-pembelian.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-square-o"></i> {{ trans('retur_pembelian.button.tambah') }}
                        </a>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Kode Pembelian</th>
                                    <th>Tanggal</th>
                                    <th>Supplier</th>
                                    <th>Gudang</th>
                                    <th>Rate</th>
                                    <th>Total Item</th>
                                    <th>Grandtotal</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($retur as $data)
                                    <tr class="odd gradeX">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->kode }}</td>
                                        <td>{{ $data->pembelian->kode }}</td>
                                        <td>{{ $data->tanggal->format('d F Y') }}</td>
                                        <td>{{ $data->pembelian->supplier ? $data->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}
                                        </td>
                                        <td>{{ $data->gudang->nama }}</td>
                                        <td>{{ $data->rate }}</td>
                                        <td>{{ $data->retur_pembelian_detail_count }}</td>
                                        <td>{{ $data->pembelian->matauang->kode . ' ' . number_format($data->total_netto) }}
                                        </td>
                                        <td>
                                            <a href="{{ route('retur-pembelian.show', $data->id) }}"
                                                class="btn btn-info btn-icon btn-circle">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <a href="{{ route('retur-pembelian.edit', $data->id) }}"
                                                class="btn btn-success btn-icon btn-circle">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ route('retur-pembelian.destroy', $data->id) }}"
                                                method="post" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('delete')

                                                <button class="btn btn-danger btn-icon btn-circle">
                                                    <i class="ace-icon fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
