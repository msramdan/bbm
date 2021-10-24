@extends('layouts.dashboard')

@section('title', trans('adjustment_plus.title.index'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('adjustment_plus') }}
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
                        <a href="{{ route('adjustment-plus.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-square-o"></i> {{ trans('adjustment_plus.button.tambah') }}
                        </a>
                    </div>
                    <div class="panel-body">
                        <table id="data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Tanggal</th>
                                    <th>Mata Uang</th>
                                    <th>Gudang</th>
                                    <th>Rate</th>
                                    <th>Total Item</th>
                                    <th>Grandtotal</th>
                                    @if (auth()->user()->can('edit adjustment plus') || auth()->user()->can('delete adjustment plus'))
                                        <th>Action</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adjustmentPlus as $data)
                                    <tr class="odd gradeX">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $data->kode }}</td>
                                        <td>{{ $data->tanggal->format('d m Y') }}</td>
                                        <td>{{ $data->matauang->nama }}</td>
                                        <td>{{ $data->gudang->nama }}</td>
                                        <td>{{ $data->rate }}</td>
                                        <td>{{ $data->adjustment_plus_detail_count }}</td>
                                        <td>{{ $data->matauang->kode . ' ' . number_format($data->grand_total) }}</td>
                                        @if (auth()->user()->can('edit adjustment plus') || auth()->user()->can('delete adjustment plus'))
                                            <td>
                                                @can('edit adjustment plus')
                                                        <a href="{{ route('adjustment-minus.edit', $data->id) }}"
                                                            class="btn btn-success btn-icon btn-circle">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                @endcan

                                                @can('detail adjustment plus')
                                                        <a href="{{ route('adjustment-minus.show', $data->id) }}"
                                                            class="btn btn-success btn-icon btn-circle">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                @endcan

                                                @can('delete adjustment plus')
                                                        <form action="{{ route('adjustment-minus.destroy', $data->id) }}" method="post"
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
