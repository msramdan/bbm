@extends('layouts.dashboard')

@section('title', trans('cek_giro_cair.title.index'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('cek_giro_cair') }}
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
                        <a href="{{ route('cek-giro-cair.create') }}" class="btn btn-success">
                            <i class="fa fa-plus-square-o"></i> {{ trans('cek_giro_cair.button.tambah') }}
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
                                        <th>No. Cek/Giro</th>
                                        <th>Jenis Cek/Giro</th>
                                        <th>Dicairkan ke</th>
                                        <th>Nilai Cek/Giro</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        @if (auth()->user()->can('edit cek/giro cair') ||
        auth()->user()->can('delete cek/giro cair'))
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
            '{{ auth()->user()->can('edit cek/giro cair') ||
auth()->user()->can('delete cek/giro cair')
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
                data: 'no_cek_giro',
                name: 'no_cek_giro'
            },
            {
                data: 'jenis_cek',
                name: 'jenis_cek'
            },
            {
                data: 'dicairkan_ke',
                name: 'dicairkan_ke'
            },
            {
                data: 'nilai_cek_giro',
                name: 'nilai_cek_giro'
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
            ajax: "{{ route('cek-giro-cair.index') }}",
            columns: columns,
            search: {
                "regex": true
            }
        });
    </script>
@endpush
