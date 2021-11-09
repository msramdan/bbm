@extends('layouts.dashboard')

@section('title', trans('pelunasan_piutang.title.tambah'))

@section('content')
    <!-- begin #content -->
    <div id="content" class="content">
        {{ Breadcrumbs::render('pelunasan_piutang_add') }}
        <!-- begin row -->
        <div class="row">
            <form action="{{ route('pelunasan-piutang.update', $pelunasanPiutang->id) }}" method="post">
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
                            <h4 class="panel-title">{{ trans('pelunasan_piutang.title.tambah') }} - Header</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 1em;">
                                <div class="col-md-3">
                                    <label for="kode" class="control-label">Kode</label>
                                    <input type="text" name="kode" class="form-control" placeholder="Kode" id="kode"
                                        value="{{ $pelunasanPiutang->kode }}" readonly />
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
                                        value="{{ $pelunasanPiutang->rate }}" required />
                                    @error('rate')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="penjualan">Kode Penjualan</label>
                                    <select name="penjualan" id="penjualan" class="form-control">
                                        <option value="{{ $pelunasanPiutang->penjualan_id }}">
                                            {{ $pelunasanPiutang->penjualan->kode }}</option>
                                        @foreach ($penjualanBelumLunas as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->kode }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('penjualan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="row form-group">
                                <div class="col-md-3">
                                    <label for="tgl_penjualan" class="control-label">Tanggal penjualan</label>
                                    <input type="text" name="tgl_penjualan" class="form-control"
                                        placeholder="Tanggal penjualan" id="tgl_penjualan" readonly
                                        value="{{ $pelunasanPiutang->penjualan->tanggal->format('d/m/Y') }}" />
                                    @error('tgl_penjualan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="pelanggan" class="control-label">Pelanggan</label>
                                    <input type="text" name="pelanggan" class="form-control" placeholder="pelanggan"
                                        id="pelanggan"
                                        value="{{ $pelunasanPiutang->penjualan->pelanggan ? $pelunasanPiutang->penjualan->pelanggan->nama_pelanggan : 'Tanpa pelanggan' }}"
                                        readonly />
                                    @error('pelanggan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="saldo_piutang" class="control-label">Saldo piutang</label>
                                    <input type="text" name="saldo_piutang" class="form-control"
                                        placeholder="Saldo piutang" id="saldo_piutang"
                                        value="{{ $pelunasanPiutang->penjualan->total_netto }}" readonly />
                                    @error('saldo_piutang')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="matauang" class="control-label">Mata Uang</label>
                                    <input type="text" name="matauang" class="form-control" placeholder="Mata Uang"
                                        id="matauang" value="{{ $pelunasanPiutang->penjualan->matauang->nama }}"
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
                            <h4 class="panel-title">{{ trans('pelunasan_piutang.title.payment_list') }}</h4>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row" style="margin-bottom: 10px">
                                {{-- Jenis Pembayaran --}}
                                <div class="col-md-4">
                                    <label class="control-label">Jenis Pembayaran</label>
                                    <select name="jenis_pembayaran" id="jenis_pembayaran" class="form-control" required>
                                        @forelse ($jenisPembayaran as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $pelunasanPiutang->jenis_pembayaran == $item->nama ? 'selected' : '' }}>
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
                                                {{ $pelunasanPiutang->bank && $pelunasanPiutang->bank->id == $item->id ? 'selected' : '' }}>
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
                                        value="{{ $pelunasanPiutang->no_cek_giro }}" />
                                    @error('no_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Tgl. Cek/Giro --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="tgl_cek_giro">Tgl. Cek/Giro</label>
                                    <input type="date" name="tgl_cek_giro" id="tgl_cek_giro" class="form-control"
                                        placeholder="Tgl. Cek/Giro" value="{{ $pelunasanPiutang->tgl_cek_giro }}"
                                        disabled />
                                    @error('tgl_cek_giro')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Bayar --}}
                                <div class="col-md-4" style="margin-top: 1em;">
                                    <label for="bayar">Bayar</label>
                                    <input type="number" step="any" name="bayar" id="bayar" class="form-control" required
                                        placeholder="Bayar" value="{{ $pelunasanPiutang->bayar }}" />
                                    @error('bayar')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- keterangan --}}
                                <div class="col-md-12" style="margin-top: 1em;">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" required
                                        placeholder="Keterangan" rows="5">{{ $pelunasanPiutang->keterangan }}</textarea>
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
        let selected_rekening = '{{ $pelunasanPiutang->rekening_bank ? $pelunasanPiutang->rekening_bank->id : '' }}'

        if ($('#bank :selected').val()) {
            $('#bank').prop('disabled', false)
            if ($('#jenis_pembayaran').val() == 'Transfer') {
                get_rekening()
            }
        }

        if ($('#tgl_cek_giro').val()) {
            $('#tgl_cek_giro').prop('disabled', false)
        }

        if ($('#no_cek_giro').val()) {
            $('#no_cek_giro').prop('disabled', false)
        }

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
                bank.val('')
                bank.prop('disabled', false)
                rekening.prop('disabled', true)

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
                bank.prop('disabled', false)
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

        $('#penjualan').change(function() {
            $.ajax({
                url: "/keuangan/pelunasan-piutang/get-penjualan-belum-lunas/" + $(this).val(),
                type: 'GET',
                success: function(data) {
                    $('#pelanggan').val('Loading...')
                    $('#saldo_piutang').val('Loading...')
                    $('#matauang').val('Loading...')
                    $('#tgl_penjualan').val('Loading...')

                    setTimeout(() => {
                        let format = new Date(data.tanggal)

                        $('#pelanggan').val(data.pelanggan ? data.pelanggan.nama_pelanggan :
                            'Tanpa pelanggan')
                        $('#saldo_piutang').val(data.total_netto)
                        $('#matauang').val(data.matauang.nama)
                        $('#tgl_penjualan').val(format.toLocaleDateString('id-ID'))
                    }, 1000);
                }
            })
        })

        $('#tanggal').change(function() {
            $.ajax({
                url: "keuangan/pelunasan-piutang/generate-kode/" + $('input[name="tanggal"]').val(),
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
            if ($('#jenis_pembayaran').val() == 'Transfer') {
                get_rekening()
            }
        })

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
                                $('#rekening option[value=' + selected_rekening + ']').attr('selected',
                                    'selected')
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
