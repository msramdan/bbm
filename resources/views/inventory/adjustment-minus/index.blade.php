@extends('layouts.dashboard')

@section('title', trans('adjustment_minus.title.index'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('adjustment_minus') }}
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
                        <a href="{{ route('adjustment-minus.create') }}" class="btn btn-success{{ !auth()->user()->can('create adjustment minus') ? ' disabled' : '' }}">
                            <i class="fa fa-minus-square-o"></i> {{ trans('adjustment_minus.button.tambah') }}
                        </a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped data-table" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Tanggal</th>
                                        <th>Gudang</th>
                                        <th>Total Barang</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        @if (auth()->user()->can('edit adjustment minus') ||
        auth()->user()->can('delete adjustment minus'))
                                            <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
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
@endsection

@push('custom-js')
    <script>
        const action =
            '{{ auth()->user()->can('edit adjustment minus') ||
auth()->user()->can('delete adjustment minus')
    ? 'yes yes yes'
    : '' }}'

        let columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'kode',
                name: 'kode'
            },
            {
                data: 'tanggal',
                name: 'tanggal'
            },
            {
                data: 'gudang',
                name: 'gudang'
            },
            {
                data: 'total_barang',
                name: 'total_barang'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'updated_at',
                name: 'updated_at'
            }
        ]

        if (action) {
            columns.push({
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            })
        }

        $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('adjustment-minus.index') }}",
            columns: columns,
        });
    </script>
@endpush
