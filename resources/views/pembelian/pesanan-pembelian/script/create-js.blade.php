@push('custom-js')
    <script type="text/javascript">
        window.addEventListener('beforeunload', function(e) {
            e.preventDefault()
            e.returnValue = ''
        })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        get_kode()
        cek_form_entry()

        $('#matauang').change(function() {
            hitung_semua_total()
        })

        $('input[name="tanggal"]').change(function() {
            get_kode()
        })

        $('#qty_input, #harga_input, #kode_input, #diskon_input, #diskon_persen_input, #ppn_input,#pph_input, #gross_input, #biaya_masuk_input, #clr_fee_input, #checkbox_ppn, #checkbox_pph')
            .on('keyup keydown change',
                function() {
                    gross = $('#qty_input').val() * $('#harga_input').val()

                    $('#gross_input').val(gross)

                    hitung_netto()

                    cek_form_entry()
                })

        $('#form_trx').submit(function(e) {
            e.preventDefault()

            // !$('select[name="supplier"]').val() ||

            if (
                !$('input[name="tanggal"]').val() ||
                !$('input[name="rate"]').val() ||
                !$('select[name="bentuk_kepemilikan"]').val() ||
                !$('select[name="matauang"]').val()
            ) {
                $('select[name="bentuk_kepemilikan"]').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Mohon isi data Pesanan Pembelian - Header terlebih dahulu!'
                })
            } else {
                let kode_barang = $('#kode_barang_input option:selected')
                let harga = $('#harga_input').val()
                let qty = $('#qty_input').val()
                let ppn = $('#ppn_input').val()
                let pph = $('#pph_input').val()
                let diskon = $('#diskon_input').val()
                let diskon_persen = $('#diskon_persen_input').val() ? parseFloat($('#diskon_persen_input').val()) :
                    0
                let biaya_masuk = $('#biaya_masuk_input').val() ? parseFloat($('#biaya_masuk_input').val()) : 0
                let clr_fee = $('#clr_fee_input').val() ? parseFloat($('#clr_fee_input').val()) : 0
                let netto = $('#netto_input').val()

                let gross = harga * qty

                // cek duplikasi barang
                $('input[name="barang[]"]').each(function() {
                    // cari index tr ke berapa
                    let index = $(this).parent().parent().index()

                    // kalo id barang di cart dan form input(barang) sama
                    //  kalo id supplier di cart dan form input(barang) sama
                    if ($(this).val() == kode_barang.val()) {
                        // hapus tr berdasarkan index
                        $('#tbl_trx tbody tr:eq(' + index + ')').remove()

                        generate_nomer()
                    }
                })

                let no = $('#tbl_trx tbody tr').length + 1

                let data_trx = `<tr>
                    <td>${no}</td>
                    <td>
                        ${kode_barang.html()}
                        <input type="hidden" class="kode_barang_hidden" name="barang[]" value="${kode_barang.val()}">
                    </td>
                    <td>
                        ${format_ribuan(harga)}
                        <input type="hidden"  class="harga_hidden" name="harga[]" value="${harga}">
                    </td>
                    <td>
                        ${format_ribuan(qty)}
                        <input type="hidden"  class="qty_hidden" name="qty[]" value="${qty}">
                    </td>
                    <td>
                        ${format_ribuan(diskon_persen)}%
                        <input type="hidden"  class="diskon_persen_hidden" name="diskon_persen[]" value="${diskon_persen}">
                    </td>
                    <td>
                        ${format_ribuan(diskon)}
                        <input type="hidden"  class="diskon_hidden" name="diskon[]" value="${diskon}">
                    </td>
                    <td>
                        ${format_ribuan(gross)}
                        <input type="hidden" name="gross[]" class="gross_hidden" value="${gross}">
                    </td>
                    <td>
                        ${format_ribuan(ppn)}
                        <input type="hidden"  class="ppn_hidden" name="ppn[]" value="${ppn}">
                    </td>
                    <td>
                        ${format_ribuan(pph)}
                        <input type="hidden"  class="pph_hidden" name="pph[]" value="${pph}">
                    </td>
                    <td>
                        ${format_ribuan(biaya_masuk)}
                        <input type="hidden"  class="biaya_masuk_hidden" name="biaya_masuk[]" value="${biaya_masuk}">
                    </td>
                    <td>
                        ${format_ribuan(clr_fee)}
                        <input type="hidden"  class="clr_fee_hidden" name="clr_fee[]" value="${clr_fee}">
                    </td>
                    <td>
                        ${format_ribuan(netto)}
                        <input type="hidden"  class="netto_hidden" name="netto[]" value="${netto}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs btn_edit">
                            <i class="fa fa-edit"></i>
                        </button>

                        <button type="button" class="btn btn-danger btn-xs btn_hapus">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>`

                $('#tbl_trx').append(data_trx)

                cek_table_length()

                clear_form_entry()

                hitung_semua_total()

                $('#kode_barang_input').focus()
            }
        })

        $('#btn_clear_form').click(function() {
            clear_form_entry()

            cek_table_length()
        })

        $('#btn_update').click(function() {
            update_list($('#index_tr').val())
        })

        $('#btn_clear_table').click(function() {
            $('#tbl_trx tbody tr').remove()

            clear_form_entry()
            hitung_semua_total()
            cek_table_length()
        })

        $('#btn_simpan').click(function() {
            $(this).prop('disabled', true)
            $(this).text('loading...')

            let data = {
                // header
                kode: $('input[name="kode"]').val(),
                tanggal: $('input[name="tanggal"]').val(),
                matauang: $('select[name="matauang"]').val(),
                supplier: $('select[name="supplier"]').val(),
                rate: $('input[name="rate"]').val(),
                keterangan: $('#keterangan').val(),
                bentuk_kepemilikan: $('#bentuk_kepemilikan').val(),

                // list
                subtotal: $('#subtotal').val(),
                total_ppn: $('#total_ppn').val(),
                total_pph: $('#total_pph').val(),
                total_diskon: $('#total_diskon').val(),
                total_biaya_masuk: $('#total_biaya_masuk').val(),
                total_gross: $('#total_gross').val(),
                total_clr_fee: $('#total_clr_fee').val(),
                total_netto: $('#total_netto').val(),

                // detail barang
                barang: $('input[name="barang[]"]').map(function() {
                    return $(this).val()
                }).get(),
                harga: $('input[name="harga[]"]').map(function() {
                    return $(this).val()
                }).get(),
                qty: $('input[name="qty[]"]').map(function() {
                    return $(this).val()
                }).get(),
                diskon: $('input[name="diskon[]"]').map(function() {
                    return $(this).val()
                }).get(),
                gross: $('input[name="gross[]"]').map(function() {
                    return $(this).val()
                }).get(),
                diskon_persen: $('input[name="diskon_persen[]"]').map(function() {
                    return $(this).val()
                }).get(),
                ppn: $('input[name="ppn[]"]').map(function() {
                    return $(this).val()
                }).get(),
                pph: $('input[name="pph[]"]').map(function() {
                    return $(this).val()
                }).get(),
                biaya_masuk: $('input[name="biaya_masuk[]"]').map(function() {
                    return $(this).val()
                }).get(),
                netto: $('input[name="netto[]"]').map(function() {
                    return $(this).val()
                }).get(),
                clr_fee: $('input[name="clr_fee[]"]').map(function() {
                    return $(this).val()
                }).get(),
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('pesanan-pembelian.store') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(data) {
                    $('#tbl_trx tbody tr').remove()

                    $('input[name="tanggal"]').val("{{ date('Y-m-d') }}")
                    $('input[name="rate"]').val('')
                    $('textarea[name="keterangan"]').val('')

                    $('select[name="supplier"] option[value=""]').attr('selected', 'selected')
                    $('select[name="matauang"] option[value=""]').attr('selected', 'selected')
                    $('select[name="bentuk_kepemilikan"] option[value="1"]').attr('selected',
                        'selected')

                    clear_form_entry()
                    hitung_semua_total()
                    cek_table_length()
                    get_kode()

                    $('select[name="bentuk_kepemilikan"]').focus()
                    $('#btn_simpan').text('simpan')

                    Swal.fire({
                        icon: 'success',
                        title: 'Tambah data',
                        text: 'Berhasil'
                    })
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        })

        $(document).on('click', '.btn_hapus', function(e) {
            e.preventDefault()

            $(this).parent().parent().remove()

            generate_nomer()
            hitung_semua_total()
            cek_table_length()
        })

        $(document).on('click', '.btn_edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            let kode_barang = $('.kode_barang_hidden:eq(' + index + ')').val()
            let harga = $('.harga_hidden:eq(' + index + ')').val()
            let qty = $('.qty_hidden:eq(' + index + ')').val()
            let gross = $('.gross_hidden:eq(' + index + ')').val()
            let diskon = $('.diskon_hidden:eq(' + index + ')').val()
            let diskon_persen = $('.diskon_persen_hidden:eq(' + index + ')').val()
            let ppn = $('.ppn_hidden:eq(' + index + ')').val()
            let pph = $('.pph_hidden:eq(' + index + ')').val()
            let biaya_masuk = $('.biaya_masuk_hidden:eq(' + index + ')').val()
            let clr_fee = $('.clr_fee_hidden:eq(' + index + ')').val()
            let netto = $('.netto_hidden:eq(' + index + ')').val()

            $('#kode_barang_input option[value="' + kode_barang + '"]').attr('selected', 'selected')

            $('#harga_input').val(harga)
            $('#qty_input').val(qty)
            $('#gross_input').val(gross)
            $('#diskon_input').val(diskon)
            $('#diskon_persen_input').val(diskon_persen)
            $('#ppn_input').val(ppn)
            $('#pph_input').val(pph)
            $('#biaya_masuk_input').val(biaya_masuk)
            $('#clr_fee_input').val(clr_fee)
            $('#netto_input').val(netto)

            $('#btn_add').hide()
            $('#btn_update').show()

            $('#index_tr').val(index)
        })

        // hitung jumlan <> pada table#tbl_trx
        function cek_table_length() {
            let total = $('#tbl_trx tbody tr').length

            if (total > 0) {
                $('#btn_simpan').prop('disabled', false)
                $('#btn_clear_table').prop('disabled', false)
            } else {
                $('#btn_simpan').prop('disabled', true)
                $('#btn_clear_table').prop('disabled', true)
            }
        }

        function update_list(index) {
            let kode_barang = $('#kode_barang_input option:selected')
            let harga = $('#harga_input').val()
            let qty = $('#qty_input').val()
            let ppn = $('#ppn_input').val()
            let pph = $('#pph_input').val()
            let diskon = $('#diskon_input').val()
            let diskon_persen = $('#diskon_persen_input').val() ? parseFloat($('#diskon_persen_input').val()) :
                0
            let biaya_masuk = $('#biaya_masuk_input').val() ? parseFloat($('#biaya_masuk_input').val()) : 0
            let clr_fee = $('#clr_fee_input').val() ? parseFloat($('#clr_fee_input').val()) : 0
            let netto = $('#netto_input').val()

            let gross = harga * qty

            let no = parseInt(parseInt(index) + 1)

            let data_trx = `<td>${no}</td>
                <td>
                    ${kode_barang.html()}
                    <input type="hidden" class="kode_barang_hidden" name="barang[]" value="${kode_barang.val()}">
                </td>
                <td>
                    ${format_ribuan(harga)}
                        <input type="hidden"  class="harga_hidden" name="harga[]" value="${harga}">
                </td>
                <td>
                    ${format_ribuan(qty)}
                        <input type="hidden"  class="qty_hidden" name="qty[]" value="${qty}">
                </td>
                <td>
                    ${format_ribuan(diskon_persen)}%
                    <input type="hidden"  class="diskon_persen_hidden" name="diskon_persen[]" value="${diskon_persen}">
                </td>
                <td>
                    ${format_ribuan(diskon)}
                    <input type="hidden"  class="diskon_hidden" name="diskon[]" value="${diskon}">
                </td>
                <td>
                    ${format_ribuan(gross)}
                    <input type="hidden" name="gross[]" class="gross_hidden" value="${gross}">
                </td>
                <td>
                    ${format_ribuan(ppn)}
                    <input type="hidden"  class="ppn_hidden" name="ppn[]" value="${ppn}">
                </td>
                <td>
                    ${format_ribuan(pph)}
                    <input type="hidden"  class="pph_hidden" name="pph[]" value="${pph}">
                </td>
                <td>
                    ${format_ribuan(biaya_masuk)}
                    <input type="hidden"  class="biaya_masuk_hidden" name="biaya_masuk[]" value="${biaya_masuk}">
                </td>
                <td>
                    ${format_ribuan(clr_fee)}
                    <input type="hidden"  class="clr_fee_hidden" name="clr_fee[]" value="${clr_fee}">
                </td>
                <td>
                    ${format_ribuan(netto)}
                    <input type="hidden"  class="netto_hidden" name="netto[]" value="${netto}">
                </td>
                <td>
                    <button type="button" class="btn btn-info btn-xs btn_edit">
                        <i class="fa fa-edit"></i>
                    </button>

                    <button type="button" class="btn btn-danger btn-xs btn_hapus">
                        <i class="fa fa-times"></i>
                    </button>
                </td>`

            $('#tbl_trx tbody tr:eq(' + index + ')').html(data_trx)

            clear_form_entry()

            hitung_semua_total()
        }

        function clear_form_entry() {
            $('#kode_barang_input option[value=""]').attr('selected', 'selected')
            $('#harga_input').val('')
            $('#qty_input').val('')
            $('#ppn_input').val('')
            $('#pph_input').val('')
            $('#gross_input').val('')
            $('#netto_input').val('')
            $('#diskon_input').val('')
            $('#diskon_persen_input').val('')
            $('#biaya_masuk_input').val('')
            $('#clr_fee_input').val('')

            $('#btn_update').hide()
            $('#btn_add').show()
        }

        // ajax get kode
        function get_kode() {
            $.ajax({
                url: "/beli/pesanan-pembelian/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    // setTimeout(() => {
                    //     $('input[name="kode"]').val('Loading...')
                    // }, 500)

                    $('input[name="kode"]').val(data)
                }
            })
        }

        function hitung_semua_total() {
            let subtotal = 0
            let total_pph = 0
            let total_ppn = 0
            let total_diskon = 0
            let total_biaya_masuk = 0
            let total_gross = 0
            let total_clr_fee = 0
            let total_netto = 0
            let matauang = $('#matauang option:selected').html()

            $('input[name="harga[]"]').map(function() {
                subtotal += parseFloat($(this).val())
            }).get()

            $('input[name="pph[]"]').map(function() {
                total_pph += parseFloat($(this).val())
            }).get()

            $('input[name="ppn[]"]').map(function() {
                total_ppn += parseFloat($(this).val())
            }).get()

            $('input[name="diskon[]"]').map(function() {
                total_diskon += parseFloat($(this).val())
            }).get()

            $('input[name="biaya_masuk[]"]').map(function() {
                total_biaya_masuk += parseFloat($(this).val())
            }).get()

            $('input[name="clr_fee[]"]').map(function() {
                total_clr_fee += parseFloat($(this).val())
            }).get()

            $('input[name="netto[]"]').map(function() {
                total_netto += parseFloat($(this).val())
            }).get()

            $('input[name="gross[]"]').map(function() {
                total_gross += parseFloat($(this).val())
            }).get()

            $('#subtotal').val(subtotal)
            $('#total_ppn').val(total_ppn)
            $('#total_pph').val(total_pph)
            $('#total_diskon').val(total_diskon)
            $('#total_biaya_masuk').val(total_biaya_masuk)
            $('#total_clr_fee').val(total_clr_fee)
            $('#total_netto').val(total_netto)
            $('#total_gross').val(total_gross)

            cek_form_entry()
        }

        function hitung_netto() {

            // let ppn = ? parseFloat($('#ppn_input').val()) : 0
            // let pph = ? parseFloat($('#pph_input').val()) : 0
            // let diskon = ? parseFloat($('#diskon_input').val()) : 0

            let harga = $('#harga_input').val() ? parseFloat($('#harga_input').val()) : 0
            let qty = $('#qty_input').val() ? parseFloat($('#qty_input').val()) : 0
            let diskon_persen = $('#diskon_persen_input').val() ? parseFloat($('#diskon_persen_input').val()) : 0
            let biaya_masuk = $('#biaya_masuk_input').val() ? parseFloat($('#biaya_masuk_input').val()) : 0
            let clr_fee = $('#clr_fee_input').val() ? parseFloat($('#clr_fee_input').val()) : 0

            let diskon = harga * diskon_persen / 100
            let gross = harga * qty - diskon

            let ppn = 0
            let pph = 0

            if ($('#checkbox_ppn').is(':checked')) {
                // gross*10%
                ppn = gross * 0.1
            }

            if ($('#checkbox_pph').is(':checked')) {
                pph = ppn / 4
            }

            let netto = gross + ppn + pph + biaya_masuk + clr_fee

            $('#diskon_input').val(diskon)
            $('#ppn_input').val(ppn)
            $('#pph_input').val(pph)
            $('#netto_input').val(netto)
            $('#gross_input').val(gross)
        }

        function format_ribuan(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
        }

        // auto generate no pada table
        function generate_nomer() {
            let no = 1
            $('#tbl_trx tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        // cek apakah form entry(adjusment plus - list) kosong atau tidak
        // kalo kosong buat button(add & clear) disabled
        function cek_form_entry() {
            if (
                !$('#kode_barang_input').val() ||
                !$('#harga_input').val() ||
                !$('#qty_input').val()
            ) {
                $('#btn_add').prop('disabled', true)
                $('#btn_clear_form').prop('disabled', true)
            } else {
                $('#btn_add').prop('disabled', false)
                $('#btn_clear_form').prop('disabled', false)
            }
        }
    </script>
@endpush
