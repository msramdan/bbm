@push('custom-js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"
        integrity="sha256-EQtsX9S1OVXguoTG+N488HS0oZ1+s80IbOEbE3wzJig=" crossorigin="anonymous"></script>

    <script>
        cek_form_entry()

        $('input[name="tanggal"]').change(function() {
            get_kode()
        })

        $('#kode_input, #bentuk_kepemilikan_input, #qty_input')
            .on('keyup keydown change', function() {
                cek_form_entry()
            })

        function cek_stok(id) {
            // kosongin dulu
            $('#stok').val('')
            $('#min_stok').val('')

            $.ajax({
                url: `/masterdata/barang/cek-stok/${id}`,
                type: 'GET',
                success: function(data) {
                    // baru isi lagi dengan yang baru
                    $('#stok').val(data.stok)
                    $('#min_stok').val(data.min_stok)
                    console.log('cek_stok() stok: ' + $('#stok').val());
                    console.log('cek_stok() min_stok: ' + $('#min_stok').val());
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

        $('#form_trx').submit(function(e) {
            e.preventDefault()
            $('#btn_add').text('Loading...')
            $('#btn_add').prop('disabled', true)

            let kode_barang = $('#kode_barang_input option:selected')
            let bentuk_kepemilikan = $('#bentuk_kepemilikan_input option:selected')
            let qty = $('#qty_input').val()

            if (
                !$('input[name="tanggal"]').val() ||
                !$('select[name="gudang"]').val() ||
                !$('select[name="paket"]').val() ||
                !$('input[name="kuantitas"]').val() ||
                !$('textarea[name="keterangan"]').val()
            ) {
                $('select[name="gudang"]').focus()

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Mohon isi data Perakitan Paket - Header terlebih dahulu!'
                })
            } else {
                $.ajax({
                    url: `/masterdata/barang/cek-stok/${kode_barang.val()}`,
                    type: 'GET',
                    success: function(data) {
                        if (data.stok == data.min_stok || qty >= data.stok) {
                            // $('#kode_barang_input option[value=""]')
                            //     .attr('selected', 'selected')
                            // $('#bentuk_kepemilikan_input option[value=""]')
                            //     .attr('selected', 'selected')

                            $('#qty_input').val('')
                            $('#btn_add').prop('disabled', true)

                            $('#qty_input').focus()

                            $('#btn_add').html('<i class="fa fa-plus"></i> Add')

                            Swal.fire({
                                icon: 'error',
                                title: 'Stok tidak mencukupi untuk dikeluarkan',
                                // njirlah kalo make variable stok/min_stok malah "kosong"
                                text: `Stok: ${data.stok}, Stok Minim: ${data.min_stok}`
                            })
                        } else {
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
                                    ${bentuk_kepemilikan.html()}
                                    <input type="hidden" class="bentuk_kepemilikan_hidden" name="bentuk_kepemilikan[]" value="${bentuk_kepemilikan.val()}">
                                </td>
                                <td>
                                    ${format_ribuan(qty)}
                                    <input type="hidden"  class="qty_hidden" name="qty[]" value="${qty}">
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

                            cek_form_entry()

                            $('#btn_add').html('<i class="fa fa-plus"></i> Add')

                            $('#kode_barang_input').focus()
                        }
                        // end data.stok == data.min_stok || qty > data.sto
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
                // end ajax
            }
            // end if
        })

        $('#btn_clear_form').click(function() {
            clear_form_entry()

            cek_table_length()

            cek_form_entry()
        })

        $('#btn_update').click(function() {
            update_list($('#index_tr').val())
        })

        $('#btn_clear_table').click(function() {
            $('#tbl_trx tbody tr').remove()

            clear_form_entry()

            cek_table_length()

            cek_form_entry()
        })

        $('#btn_simpan').click(function() {
            $(this).prop('disabled', true)
            $(this).text('loading...')

            let data = {
                kode: $('input[name="kode"]').val(),
                tanggal: $('input[name="tanggal"]').val(),
                gudang: $('select[name="gudang"]').val(),
                paket: $('select[name="gudang"]').val(),
                kuantitas: $('input[name="kuantitas"]').val(),
                keterangan: $('textarea[name="keterangan"]').val(),
                barang: $('input[name="barang[]"]').map(function() {
                    return $(this).val()
                }).get(),
                bentuk_kepemilikan: $('input[name="bentuk_kepemilikan[]"]').map(function() {
                    return $(this).val()
                }).get(),
                qty: $('input[name="qty[]"]').map(function() {
                    return $(this).val()
                }).get(),
            }

            $.ajax({
                type: 'PUT',
                url: '{{ route('perakitan-paket.update', $perakitanPaket->id) }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update data',
                        text: 'Berhasil'
                    }).then(function() {
                        setTimeout(() => {
                            window.location = '{{ route('perakitan-paket.index') }}'
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
        })

        $(document).on('click', '.btn_hapus', function(e) {
            e.preventDefault()

            $(this).parent().parent().remove()

            generate_nomer()
            cek_table_length()
        })

        $(document).on('click', '.btn_edit', function(e) {
            e.preventDefault()
            $('#btn_update').prop('disabled', false)
            $('#btn_clear_form').prop('disabled', false)

            // ambil <tr> index
            let index = $(this).parent().parent().index()

            let kode_barang = $('.kode_barang_hidden:eq(' + index + ')').val()
            let supplier = $('.supplier_hidden:eq(' + index + ')').val()
            let bentuk_kepemilikan = $('.bentuk_kepemilikan_hidden:eq(' + index + ')').val()
            let qty = $('.qty_hidden:eq(' + index + ')').val()

            $('#kode_barang_input option[value="' + kode_barang + '"]').attr('selected', 'selected')
            $('#supplier_input option[value="' + supplier + '"]').attr('selected', 'selected')
            $('#bentuk_kepemilikan_input option[value="' + bentuk_kepemilikan + '"]').attr('selected', 'selected')

            $('#qty_input').val(qty)

            $('#btn_add').hide()
            $('#btn_update').show()

            $('#index_tr').val(index)
        })

        // hitung jumlan <tr> pada table#tbl_trx
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
            $('#btn_update').text('Loading...')
            $('#btn_update').prop('disabled', true)

            let kode_barang = $('#kode_barang_input option:selected')
            let supplier = $('#supplier_input option:selected')
            let bentuk_kepemilikan = $('#bentuk_kepemilikan_input option:selected')
            let qty = $('#qty_input').val()

            let no = parseInt(parseInt(index) + 1)

            $.ajax({
                url: `/masterdata/barang/cek-stok/${kode_barang.val()}`,
                type: 'GET',
                success: function(data) {
                    if (data.stok == data.min_stok || qty >= data.stok) {
                        $('#qty_input').val('')
                        $('#qty_input').focus()

                        $('#btn_update').prop('disabled', true)
                        $('#btn_update').html('<i class="fa fa-save"></i> Update')

                        Swal.fire({
                            icon: 'error',
                            title: 'Stok tidak mencukupi untuk dikeluarkan',
                            text: `Stok: ${data.stok}, Stok Minim: ${data.min_stok}`
                        })
                    } else {
                        let data_trx = `<td>${no}</td>
                            <td>
                                ${kode_barang.html()}
                                <input type="hidden" class="kode_barang_hidden" name="barang[]" value="${kode_barang.val()}">
                            </td>
                            <td>
                                ${bentuk_kepemilikan.html()}
                                <input type="hidden" class="bentuk_kepemilikan_hidden" name="bentuk_kepemilikan[]" value="${bentuk_kepemilikan.val()}">
                            </td>
                            <td>
                                ${format_ribuan(qty)}
                                <input type="hidden"  class="qty_hidden" name="qty[]" value="${qty}">
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

                        cek_form_entry()

                        $('#btn_update').html('<i class="fa fa-save"></i> Update')
                        $('#btn_update').prop('disabled', false)
                    }
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

        function clear_form_entry() {
            $('#kode_barang_input option[value=""]').attr('selected', 'selected')
            $('#bentuk_kepemilikan_input option[value=""]').attr('selected', 'selected')

            $('#qty_input').val('')

            $('#btn_update').hide()
            $('#btn_add').show()
        }

        // ajax get kode
        function get_kode() {
            $.ajax({
                url: "/inventory/perakitan-paket/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    $('input[name="kode"]').val(data)
                }
            })
        }

        function format_ribuan(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }

        // auto generate no pada table
        function generate_nomer() {
            let no = 1
            $('#tbl_trx tbody tr').each(function() {
                $(this).find('td:nth-child(1)').html(no)
                no++
            })
        }

        // cek apakah form entry(Perakitan Paket - list) kosong atau tidak
        // kalo kosong buat button(add & clear) disabled
        function cek_form_entry() {
            if (
                !$('#kode_barang_input').val() ||
                !$('#bentuk_kepemilikan_input').val() ||
                !$('#qty_input').val()
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
    </script>
@endpush