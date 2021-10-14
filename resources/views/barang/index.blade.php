@extends('layouts.dashboard')

@section('title', trans('barang.title.index'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('barang') }}
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
                        <a href="{{ route('barang.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-square-o"></i> {{ trans('barang.button.tambah') }}
                        </a>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Kategori</th>
                                    <th>Satuan</th>
                                    <th>Harga Beli</th>
                                    <th>Harga Jual</th>
                                    <th>Harga Min. Jual</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $data)
                                    <tr class="odd gradeX">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->gambar }}</td>
                                        <td>{{ $data->kode }}</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>{{ $data->jenis }}</td>
                                        <td>{{ $data->kategori->nama }}</td>
                                        <td>{{ $data->satuan->nama }}</td>
                                        <td>{{ $data->matauang_beli->kode . ' ' . number_format($data->harga_beli) }}
                                        </td>
                                        <td>{{ $data->mata_uang_jual->kode . ' ' . number_format($data->harga_jual) }}
                                        </td>
                                        <td>{{ $data->mata_uang_jual->kode . ' ' . number_format($data->harga_jual_min) }}
                                        </td>
                                        <td>{{ $data->stok }}</td>
                                        <td>{{ $data->status == 'Y' ? 'Aktif' : 'No' }}</td>
                                        <td>
                                            <a href="{{ route('barang.edit', $data->id) }}"
                                                class="btn btn-success btn-icon btn-circle">
                                                <i class="fa fa-edit"></i>
                                            </a>

                                            <form action="{{ route('barang.destroy', $data->id) }}" method="post"
                                                class="d-inline"
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
