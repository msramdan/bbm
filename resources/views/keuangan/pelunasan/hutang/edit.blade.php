@extends('layouts.dashboard')

@section('title', trans('pelunasan_hutang.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelunasan_hutang_add') }}
        <!-- begin row -->
        <div class="row">
            <form action="{{ route('pelunasan-hutang.update', $pelunasanHutang->id) }}" method="post">
                @csrf
                @method('put')
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
                            <h4 class="panel-title">{{ trans('pelunasan_hutang.title.tambah') }} - Header</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-3">
                                    <label for="kode" class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        value="{{ $pelunasanHutang->kode }}" readonly />
                                    @error('kode')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="tanggal" class="control-label">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}"
                                        id="tanggal" />
                                    @error('tanggal')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="rate" class="control-label">Rate</label>
                                    <input type="number" name="rate" class="form-control" placeholder="Rate" id="rate"
                                        value="{{ $pelunasanHutang->rate }}" required />
                                    @error('rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="pembelian">Kode Pembelian</label>
                                    <select name="pembelian" id="pembelian" class="form-control">
                                        <option value="{{ $pelunasanHutang->pembelian_id }}">
                                            {{ $pelunasanHutang->pembelian->kode }}</option>
                                        @foreach ($pembelianBelumLunas as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->kode }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pembelian')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="tgl_pembelian" class="control-label">Tanggal Pembelian</label>
                                    <input type="text" name="tgl_pembelian" class="form-control"
                                        placeholder="Tanggal Pembelian" id="tgl_pembelian" readonly
                                        value="{{ $pelunasanHutang->pembelian->tanggal->format('d/m/Y') }}" />
                                    @error('tgl_pembelian')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="supplier" class="control-label">Supplier</label>
                                    <input type="text" name="supplier" class="form-control" placeholder="Supplier"
                                        id="supplier"
                                        value="{{ $pelunasanHutang->pembelian->supplier ? $pelunasanHutang->pembelian->supplier->nama_supplier : 'Tanpa Supplier' }}"
                                        readonly />
                                    @error('supplier')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="saldo_hutang" class="control-label">Saldo Hutang</label>
                                    <input type="text" name="saldo_hutang" class="form-control" placeholder="Saldo Hutang"
                                        id="saldo_hutang" value="{{ $pelunasanHutang->pembelian->total_netto }}"
                                        readonly />
                                    @error('saldo_hutang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="matauang" class="control-label">Mata Uang</label>
                                    <input type="text" name="matauang" class="form-control" placeholder="Mata Uang"
                                        id="matauang" value="{{ $pelunasanHutang->pembelian->matauang->nama }}"
                                        readonly />
                                    @error('matauang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end panel -->
                </div>
                <!-- end col-12 -->

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
                            <h4 class="panel-title">{{ trans('pelunasan_hutang.title.payment_list') }}</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 10px">
                                {{-- Jenis Pembayaran --}}
                                <div class="col-md-4">
                                    <label class="control-label">Jenis Pembayaran</label>
                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" required>
                                        @forelse ($jenisPembayaran as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pelunasanHutang->jenis_pembayaran == $item->nama ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('jenis_pembayaran')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Bank</label>
                                    <select name="bank" id="bank" class="form-control" disabled>
                                        <option value="" disabled selected>-- Pilih --</option>
                                        @forelse ($bank as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pelunasanHutang->bank && $pelunasanHutang->bank->id == $item->id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="" disabled>Data tidak ditemukan</option>
                                        @endforelse
                                    </select>
                                    @error('bank')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label class="control-label">Rekening</label>
                                    <select name="rekening" id="rekening" class="form-control" disabled>
                                        <option value="" disabled selected>-- Pilih Bank Terlebih Dahulu --</option>
                                    </select>
                                    @error('rekening')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- No. Cek/Giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="no_cek_giro">No. Cek/Giro </label>
                                    <input type="number" step="any" name="no_cek_giro" id="no_cek_giro"
                                        class="form-control" placeholder="No. Cek/Giro " disabled
                                        value="{{ $pelunasanHutang->no_cek_giro }}" />
                                    @error('no_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Tgl. Cek/Giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                    <input type="date" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                        placeholder="Tgl. Cek/Giro" value="{{ $pelunasanHutang->tgl_cek_giro }}"
                                        disabled />
                                    @error('tgl_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Bayar --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="bayar">Bayar</label>
                                    <input type="number" step="any" name="bayar" id="bayar" class="form-control" required
                                        placeholder="Bayar" value="{{ $pelunasanHutang->bayar }}" />
                                    @error('bayar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- keterangan --}}
                                <div class="col-md-12" style="margin-top: 1em;">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" required
                                        placeholder="Keterangan" rows="5">{{ $pelunasanHutang->keterangan }}</textarea>
                                    @error('keterangan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-12" style="margin-top: 1em;">
                                    <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                                </div>
                            </div>
                        </div>
                        {{-- end panel-body --}}
                    </div>
                    {{-- panel-inverse --}}
                </div>
                {{-- end col-md-12 --}}
            </form>
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
@endsection

@push('custom-js')
    <script>
        let selected_rekening = '{{ $pelunasanHutang->rekening_bank ? $pelunasanHutang->rekening_bank->id : '' }}'

        $('#jenis_pembayaran').change(function() {
            let jenis_pembayaran = $(this)
            let bank = $('#bank')
            let rekening = $('#rekening')
            let no_cek_giro = $('#no_cek_giro')
            let tgl_cek_giro = $('#tgl_cek_giro')
            let bayar = $('#bayar')

            // kalo cash, bank dan giro boleh kosong
            if (jenis_pembayaran.val() == 'Cash') {
                bank.prop('disabled', true)
                rekening.prop('disabled', true)
                no_cek_giro.prop('disabled', true)
                tgl_cek_giro.prop('disabled', true)

                bank.val('')
                no_cek_giro.val('')
                tgl_cek_giro.val('')
                rekening.html('<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')

                if (bayar.val()) {
                    $('#btn_add_payment').prop('disabled', false)
                    $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_add_payment').prop('disabled', true)
                    $('#btn_clear_form_payment').prop('disabled', true)
                }

                bank.prop('required', false)
                rekening.prop('required', false)
                no_cek_giro.prop('required', false)
                tgl_cek_giro.prop('required', false)
            }

            if (jenis_pembayaran.val() == 'Transfer') {
                bank.prop('disabled', false)
                rekening.prop('disabled', false)

                no_cek_giro.prop('disabled', true)
                no_cek_giro.val('')
                tgl_cek_giro.prop('disabled', true)
                tgl_cek_giro.val('')

                if (bayar.val() && bank.val() && rekening.val()) {
                    $('#btn_add_payment').prop('disabled', false)
                    $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_add_payment').prop('disabled', true)
                    $('#btn_clear_form_payment').prop('disabled', true)
                }

                bank.prop('required', true)
                rekening.prop('required', true)
            }

            if (jenis_pembayaran.val() == 'Giro') {
                bank.prop('disabled', true)
                bank.val('')
                rekening.prop('disabled', true)
                rekening.html('<option value="" disabled selected>-- Pilih Bank terlebih dahulu --</option>')

                no_cek_giro.prop('disabled', false)
                tgl_cek_giro.prop('disabled', false)

                if (bayar.val() && no_cek_giro.val() && tgl_cek_giro.val()) {
                    $('#btn_add_payment').prop('disabled', false)
                    $('#btn_clear_form_payment').prop('disabled', false)
                } else {
                    $('#btn_add_payment').prop('disabled', true)
                    $('#btn_clear_form_payment').prop('disabled', true)
                }

                no_cek_giro.prop('required', true)
                tgl_cek_giro.prop('required', true)
            }
        })

        $('#pembelian').change(function() {
            $.ajax({
                url: "/keuangan/pelunasan-hutang/get-pembelian-belum-lunas/" + $(this).val(),
                type: 'GET',
                success: function(data) {
                    $('#supplier').val('Loading...')
                    $('#saldo_hutang').val('Loading...')
                    $('#matauang').val('Loading...')
                    $('#tgl_pembelian').val('Loading...')

                    setTimeout(() => {
                        let format = new Date(data.tanggal)

                        $('#supplier').val(data.supplier ? data.supplier.nama_supplier :
                            'Tanpa Supplier')
                        $('#saldo_hutang').val(data.total_netto)
                        $('#matauang').val(data.matauang.nama)
                        $('#tgl_pembelian').val(format.toLocaleDateString('id-ID'))
                    }, 1000);
                }
            })
        })

        $('#tanggal').change(function() {
            $.ajax({
                url: "keuangan/pelunasan-hutang/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    $('input[name="kode"]').val('Loading...')

                    setTimeout(() => {
                        $('input[name="kode"]').val(data)
                    }, 1000)
                }
            })
        })

        $('#bank').change(function() {
            get_rekening()
        })

        if ($('#bank :selected').val()) {
            $('#bank').prop('disabled', false)

            get_rekening()
        }

        if ($('#tgl_cek_giro').val()) {
            $('#tgl_cek_giro').prop('disabled', false)
        }

        if ($('#no_cek_giro').val()) {
            $('#no_cek_giro').prop('disabled', false)
        }

        function get_rekening() {
            $.ajax({
                url: "/beli/pembelian/get-rekening/" + $('#bank').val(),
                type: 'GET',
                success: function(data) {
                    let rekening = []

                    $('#rekening').prop('disabled', true)
                    $('#rekening').html(
                        '<option value="" disabled selected>Loading...</option>')

                    setTimeout(() => {
                        if (data.length > 0) {
                            data.forEach(elm => {
                                rekening.push(
                                    `<option value="${elm.id}">${elm.nomor_rekening} - ${elm.nama_rekening}</option>`
                                )
                            })

                            $('#rekening').html(rekening)

                            $('#rekening').prop('disabled', false)

                            if (selected_rekening) {
                                $('#rekening option[value=' + selected_rekening + ']')
                                    .attr('selected', 'selected')
                            }
                        } else {
                            $('#rekening').html(
                                '<option value="" disabled selected>-- No.Rekening tidak ditemukan --</option>'
                            )
                        }
                    }, 1000);
                }
            })
        }
    </script>
@endpush
