@extends('layouts.dashboard')

@section('title', 'Rate Mata Uang')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('rate_matauang') }}

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
                        <a href="{{ route('rate-matauang.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-square-o"></i> {{ trans('rate_matauang.button.tambah') }}
                        </a>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Mata Uang Asing</th>
                                    <th>Mata Uang Default</th>
                                    <th>Rate</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rateMataUang as $data)
                                    <tr class="odd gradeX">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->tanggal }}</td>
                                        <td>{{ $data->matauang_asing->nama }}</td>
                                        <td>{{ $data->matauang_default }}</td>
                                        <td>{{ number_format($data->rate) . '.00' }}</td>
                                        <td>
                                            <a href="{{ route('rate-matauang.edit', $data->id) }}"
                                                class="btn btn-success btn-icon btn-circle">
                                                <i class="fa fa-edit">
                                                </i>
                                            </a>

                                            <form action="{{ route('rate-matauang.destroy', $data->id) }}" method="post"
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
