@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        cek_form_entry()

        hitung_semua_total()

        $('#qty_retur_input, #checkbox_ppn')
            .on('keyup keydown change',
                function() {
                    hitung_netto()
                    cek_form_entry()
                })

        $('#form_trx').submit(function(e) {
            e.preventDefault()

            let kode_barang = $('#kode_barang_input option:selected')
            let harga = $('#harga_input').val()
            let qty_retur = $('#qty_retur_input').val()
            let ppn = $('#ppn_input').val()

            let diskon = $('#diskon_input').val()
            let diskon_persen = $('#diskon_persen_input').val() ? parseFloat($('#diskon_persen_input').val()) : 0

            let netto = $('#netto_input').val()

            let gross = harga * qty_retur

            // cek duplikasi barang
            $('input[name="barang_id[]"]').each(function() {
                let index = $(this).parent().parent().index()

                if ($(this).val() == kode_barang.val()) {
                    $('#tbl_trx tbody tr:eq(' + index + ')').remove()
                    generate_nomer()
                }
            })

            let no = $('#tbl_trx tbody tr').length + 1

            let data_trx = `<tr>
                    <td>${no}</td>
                    <td>
                        ${kode_barang.html()}
                        <input type="hidden" class="barang_id_hidden" name="barang_id[]" value="${kode_barang.val()}">
                    </td>
                    <td>
                        ${format_ribuan(harga)}
                        <input type="hidden"  class="harga_hidden" name="harga[]" value="${harga}">
                    </td>
                    <td>
                        ${format_ribuan(qty)}
                        <input type="hidden"  class="qty_beli_hidden" name="qty_beli[]" value="${qty}">
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
                        ${format_ribuan(netto)}
                        <input type="hidden"  class="netto_hidden" name="netto[]" value="${netto}">
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-xs btn_edit">
                            <i class="fa fa-edit"></i>
                        </button>
                    </td>
                </tr>`

            $('#tbl_trx').append(data_trx)

            cek_table_length()

            clear_form_entry()

            hitung_semua_total()

            $('#kode_barang_input').focus()

        })

        $('#btn_clear_form').click(function() {
            clear_form_entry()
            cek_table_length()

            $(this).prop('disabled', true)

            $('#qty_retur_input').val('')
            $('#barang_input').val('')
            $('#barang_hidden').val('')
        })

        $('#btn_update').click(function() {
            update_list($('#index_tr').val())
        })

        $('#btn_clear_table').click(function() {
            $('#tbl_trx tbody tr').remove()

            $('#penjualan_id option:eq(0)').attr('selected', 'selected')
            $('#gudang option:eq(0)').attr('selected', 'selected')
            $('#rate').val('')
            $('#pelanggan').val('')
            $('#matauang').val('')
            $('#bentuk_kepemilikan').val('')

            $('#gudang').focus()

            clear_form_entry()
            hitung_semua_total()
            cek_table_length()
        })

        $('#btn_simpan').click(function() {
            if (
                !$('input[name="tanggal"]').val() ||
                !$('input[name="rate"]').val() ||
                !$('select[name="gudang"]').val()
            ) {
                $('select[name="gudang"]').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon isi data Retur penjualan - Header terlebih dahulu!'
                })
            } else {
                $(this).prop('disabled', true)
                $(this).text('loading...')

                let data = {
                    // header
                    kode: $('input[name="kode"]').val(),
                    penjualan_id: $('select[name="penjualan_id"]').val(),
                    tanggal: $('input[name="tanggal"]').val(),
                    rate: $('input[name="rate"]').val(),
                    gudang: $('select[name="gudang"]').val(),
                    keterangan: $('#keterangan').val(),

                    // list
                    subtotal: $('#subtotal').val(),
                    total_ppn: $('#total_ppn').val(),
                    total_diskon: $('#total_diskon').val(),
                    total_gross: $('#total_gross').val(),
                    total_netto: $('#total_netto').val(),

                    // detail barang
                    barang: $('input[name="barang_id[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                    harga: $('input[name="harga[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                    qty_beli: $('input[name="qty_beli[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                    qty_retur: $('input[name="qty_retur[]"]').map(function() {
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
                    netto: $('input[name="netto[]"]').map(function() {
                        return $(this).val()
                    }).get(),
                }

                $.ajax({
                    type: 'PUT',
                    url: '{{ route('retur-penjualan.update', $returPenjualan->id) }}',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    success: function(data) {
                        $('#btn_simpan').text('simpan')

                        Swal.fire({
                            icon: 'success',
                            title: 'Update data',
                            text: 'Berhasil'
                        }).then(function() {
                            setTimeout(() => {
                                window.location =
                                    '{{ route('retur-penjualan.index') }}'
                            }, 500)
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
            }
        })

        $(document).on('click', '.btn_edit', function(e) {
            e.preventDefault()

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            let barang_id = $('.barang_id_hidden:eq(' + index + ')').val()
            let barang_text = $('.barang_text_hidden:eq(' + index + ')').val()
            let harga = $('.harga_hidden:eq(' + index + ')').val()
            let qty_beli = $('.qty_beli_hidden:eq(' + index + ')').val()
            let qty_retur = $('.qty_retur_hidden:eq(' + index + ')').val()
            let gross = $('.gross_hidden:eq(' + index + ')').val()
            let diskon = $('.diskon_hidden:eq(' + index + ')').val()
            let diskon_persen = $('.diskon_persen_hidden:eq(' + index + ')').val()
            let ppn = $('.ppn_hidden:eq(' + index + ')').val()
            let netto = $('.netto_hidden:eq(' + index + ')').val()

            cek_stok(barang_id)

            if (ppn > 0) {
                $('#checkbox_ppn').prop('checked', true)
            } else {
                $('#checkbox_ppn').prop('checked', false)
            }

            $('#harga_input').val(harga)
            $('#qty_beli_input').val(qty_beli)
            $('#gross_input').val(gross)
            $('#diskon_input').val(diskon)
            $('#diskon_persen_input').val(diskon_persen)
            $('#ppn_input').val(ppn)
            $('#netto_input').val(netto)
            $('#barang_input').val(barang_text)
            $('#barang_hidden').val(barang_id)

            $('#btn_add').hide()
            $('#btn_update').show()

            $('#index_tr').val(index)

            $('#qty_retur_input').prop('disabled', false)
            $('#qty_retur_input').focus()
            $('#qty_retur_input').attr({
                "max": qty_beli,
                "min": 1
            })

            $('#btn_clear_form').prop('disabled', false)
            $('#btn_update').prop('disabled', true)
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
            let barang_id = $('#barang_hidden').val()
            let barang_text = $('#barang_input').val()

            let harga = $('#harga_input').val()
            let qty_beli = $('#qty_beli_input').val()
            let qty_retur = $('#qty_retur_input').val()
            let ppn = $('#ppn_input').val()
            let diskon = $('#diskon_input').val()

            let diskon_persen = $('#diskon_persen_input').val() ?
                parseFloat($('#diskon_persen_input').val()) : 0

            let netto = $('#netto_input').val()

            // let gross = harga * (qty_beli - qty_retur)
            let gross = $('#gross_input').val()

            let no = parseInt(parseInt(index) + 1)

            let data_trx = `<td>${no++}</td>
            <td> ${barang_text}
                <input type="hidden" class="barang_id_hidden" name="barang_id[]" value="${barang_id}">
                <input type="hidden" class="barang_text_hidden" name="barang_text[]" value="${barang_text}">
            </td>
            <td> ${format_ribuan(harga)}
                <input type="hidden" class="harga_hidden" name="harga[]" value="${harga}">
            </td>
            <td> ${qty_beli}
                <input type="hidden" class="qty_beli_hidden" name="qty_beli[]" value="${qty_beli}">
            </td>
            <td> ${qty_retur}
                <input type="hidden" class="qty_retur_hidden" name="qty_retur[]" value="${qty_retur}">
            </td>
            <td> ${format_ribuan(diskon_persen)}%
                <input type="hidden" class="diskon_persen_hidden" name="diskon_persen[]" value="${diskon_persen}">
            </td>
            <td> ${format_ribuan(diskon)}
                <input type="hidden" class="diskon_hidden" name="diskon[]" value="${diskon}">
            </td>
            <td> ${format_ribuan(gross)}
                <input type="hidden" name="gross[]" class="gross_hidden" value="${gross}">
            </td>
            <td> ${format_ribuan(ppn)}
                <input type="hidden" class="ppn_hidden" name="ppn[]" value="${ppn}">
            </td>
            <td> ${format_ribuan(netto)}
                <input type="hidden" class="netto_hidden" name="netto[]" value="${netto}">
            </td>
            <td>
                <button type="button" class="btn btn-info btn-xs btn_edit">
                    <i class="fa fa-edit"></i>
                </button>
            </td>`

            $('#tbl_trx tbody tr:eq(' + index + ')').html(data_trx)

            clear_form_entry()

            hitung_semua_total()

            $('#qty_retur_input').prop('disabled', true)
        }

        function clear_form_entry() {
            $('#barang_input').val('')
            $('#barang_hidden').val('')
            $('#harga_input').val('')
            $('#qty_beli_input').val('')
            $('#qty_retur_input').val('')
            $('#ppn_input').val('')
            $('#gross_input').val('')
            $('#netto_input').val('')
            $('#diskon_input').val('')
            $('#diskon_persen_input').val('')
            $('#stok_input').val('')

            $('#btn_update').hide()
            $('#btn_add').show()

            $('#btn_clear_form').prop('disabled', true)
            $('#btn_add').prop('disabled', true)
            $('#qty_retur_input').prop('disabled', true)
        }

        function hitung_semua_total() {
            let subtotal = 0
            let total_ppn = 0
            let total_diskon = 0
            let total_gross = 0
            let total_netto = 0
            let matauang = $('#matauang option:selected').html()

            $('input[name="harga[]"]').map(function() {
                subtotal += parseFloat($(this).val())
            }).get()
            $('input[name="ppn[]"]').map(function() {
                total_ppn += parseFloat($(this).val())
            }).get()
            $('input[name="diskon[]"]').map(function() {
                total_diskon += parseFloat($(this).val())
            }).get()
            $('input[name="netto[]"]').map(function() {
                total_netto += parseFloat($(this).val())
            }).get()
            $('input[name="gross[]"]').map(function() {
                total_gross += parseFloat($(this).val())
            }).get()

            $('#subtotal').val(subtotal)
            $('#total_ppn').val(total_ppn)
            $('#total_diskon').val(total_diskon)
            $('#total_netto').val(total_netto)
            $('#total_gross').val(total_gross)

            cek_form_entry()
        }

        function hitung_netto() {
            let harga = $('#harga_input').val() ?
                parseFloat($('#harga_input').val()) : 0

            let qty_retur = $('#qty_retur_input').val() ?
                parseFloat($('#qty_retur_input').val()) : 0

            let qty_beli = $('#qty_beli_input').val() ?
                parseFloat($('#qty_beli_input').val()) : 0

            let diskon_persen = $('#diskon_persen_input').val() ?
                parseFloat($('#diskon_persen_input').val()) : 0

            if (qty_retur > qty_beli) {
                $('#qty_retur_input').focus()
                $('#qty_retur_input').val('1')

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Qty Retur tidak boleh lebih besar dari Qty Beli!'
                })
            } else {
                let diskon = harga * (diskon_persen / 100)
                let gross = (harga * qty_retur) - diskon

                let ppn = 0

                if ($('#checkbox_ppn').is(':checked')) {
                    ppn = gross * 0.1
                }

                let netto = gross + ppn

                $('#diskon_input').val(diskon)
                $('#ppn_input').val(ppn)
                $('#netto_input').val(netto)
                $('#gross_input').val(gross)
            }
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
                !$('#qty_retur_input').val() ||
                $('#qty_retur_input').val() == 0 ||
                $('#qty_retur_input').val() > $('#qty_beli_input')
            ) {
                $('#btn_add').prop('disabled', true)
                $('#btn_update').prop('disabled', true)
                $('#btn_clear_form').prop('disabled', true)
            } else {
                $('#btn_add').prop('disabled', false)
                $('#btn_update').prop('disabled', false)
                $('#btn_clear_form').prop('disabled', false)
            }
        }

        function cek_stok(id) {
            let stok = $('#stok_input')
            stok.prop('disabled', true)
            stok.val('')
            stok.prop('placeholder', 'Loading...')

            $.ajax({
                url: '/masterdata/barang/cek-stok/' + id,
                type: 'GET',
                success: function(data) {
                    stok.val(data.stok)
                    stok.prop('placeholder', 'Stok')

                    $('#qty_input').focus()
                    // console.log(`stok: ${stok}, min: ${min_stok}`);
                },
                error: function(xhr, status, error) {
                    // console.error(xhr.responseText)

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!'
                    })
                }
            })
        }
    </script>
@endpush
