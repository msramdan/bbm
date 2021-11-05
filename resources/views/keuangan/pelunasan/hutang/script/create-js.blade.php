@push('custom-js')
    <script>
        get_kode()

        $('#form_trx').submit(function(e) {
            e.preventDefault()

            let kode_pembelian = $('#kode_pembelian option:selected')
            let bank = $('#bank option:selected')
            let rekening = $('#rekening option:selected')
            let tgl_pembelian = $('#tgl_pembelian').val()
            let supplier = $('#supplier').val()
            let jenis_pembayaran = $('#jenis_pembayaran').val()
            let matauang = $('#matauang').val()
            let no_cek_giro = $('#no_cek_giro').val()
            let tgl_cek_giro = $('#tgl_cek_giro').val()
            let keterangan = $('#keterangan').val()
            let hutang = parseFloat($('#saldo_hutang').val())
            let bayar = parseFloat($('#bayar').val())
            let no = $('#tbl_trx tbody tr').length + 1

            console.log(kode_pembelian.html());
            console.log(kode_pembelian.val());

            // cek duplikasi kode_pembelian
            $('input[name="kode_pembelian[]"]').each(function() {
                // cari index tr ke berapa
                let index = $(this).parent().parent().index()
                // kalo id kode_pembelian di cart dan form input(kode_pembelian) sama
                //  kalo id supplier di cart dan form input(kode_pembelian) sama
                if ($(this).val() == kode_pembelian.val()) {
                    // hapus tr berdasarkan index
                    $('#tbl_trx tbody tr:eq(' + index + ')').remove()
                    generate_nomer()
                }
            })
            let data_trx = `<tr>
                <td>${no}</td>
                <td>
                    ${kode_pembelian.html()}
                    <input type="hidden" class="kode_pembelian" name="kode_pembelian[]" value="${kode_pembelian.val()}">
                </td>
                <td>
                    ${tgl_pembelian}
                    <input type="hidden" class="tgl_pembelian" name="tgl_pembelian[]" value="${tgl_pembelian}">
                </td>
                <td>
                    ${supplier}
                    <input type="hidden" class="supplier" name="supplier[]" value="${supplier}">
                </td>
                <td>${matauang}
                    <input type="hidden" class="matauang" name="matauang[]" value="${matauang}">
                </td>
                <td>${format_ribuan(hutang)}
                    <input type="hidden" class="hutang" name="hutang[]" value="${hutang}">
                </td>
                <td>
                    <span>${jenis_pembayaran}</span>
                    <br>
                    <span>Bank: ${bank.html()}</span>
                    <br>
                    <span>No. Rek: ${rekening.html()}</span>
                    <input type="hidden" class="jenis_pembayaran" name="jenis_pembayaran[]">
                    <input type="hidden" class="bank" name="bank[]" value="${bank.val()}">
                    <input type="hidden" class="rekening" name="rekening[]" value="${rekening.val()}">
                    <input type="hidden" class="no_cek_giro" name="no_cek_giro[]" value="${no_cek_giro}">
                    <input type="hidden" class="tgl_cek_giro" name="tgl_cek_giro[]" value="${tgl_cek_giro}">
                </td>
                <td>${format_ribuan(bayar)}
                    <input type="hidden" class="bayar" name="bayar[]" value="${bayar}">
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
        })


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

        $('#kode_pembelian').change(function() {
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

        $('#bank').change(function() {
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
                        } else {
                            $('#rekening').html(
                                '<option value="" disabled selected>-- No.Rekening tidak ditemukan --</option>'
                            )
                        }
                    }, 1000);
                }
            })
        })

        $('#tanggal').change(function() {
            get_kode()
        })

        function get_kode() {
            $.ajax({
                url: "/keuangan/pelunasan-hutang/generate-kode/" + $('input[name="tanggal"]').val(),
                type: 'GET',
                success: function(data) {
                    $('input[name="kode"]').val('Loading...')

                    setTimeout(() => {
                        $('input[name="kode"]').val(data)
                    }, 1000)
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
    </script>
@endpush
