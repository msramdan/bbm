@extends('layouts.dashboard')

@section('title', 'Rekening Bank')

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('rekening_bank') }}
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
                        <a href="{{ route('rekening-bank.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-square-o"></i> {{ trans('rekening_bank.button.tambah') }}
                        </a>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Bank</th>
                                    <th>No. Rekening</th>
                                    <th>Nama Rekening</th>
                                    <th>Status</th>
                                    @if (auth()->user()->can('edit rekening') || auth()->user()->can('delete rekening'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rekeningBank as $data)
                                    <tr class="odd gradeX">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->kode }}</td>
                                        <td>{{ $data->bank->nama }}</td>
                                        <td>{{ $data->nomor_rekening }}</td>
                                        <td>{{ $data->nama_rekening }}</td>
                                        <td>{{ $data->status == 'Y' ? 'Aktif' : 'No' }}</td>
                                        @if (auth()->user()->can('edit rekening') || auth()->user()->can('delete rekening'))
                                            <td>
                                                @can('edit rekening')
                                                    <a href="{{ route('rekening-bank.edit', $data->id) }}"
                                                        class="btn btn-success btn-icon btn-circle">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan

                                                @can('delete rekening')
                                                    <form action="{{ route('rekening-bank.destroy', $data->id) }}" method="post"
                                                        class="d-inline"
                                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('delete')

                                                        <button class="btn btn-danger btn-icon btn-circle">
                                                            <i class="ace-icon fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        @endif
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
