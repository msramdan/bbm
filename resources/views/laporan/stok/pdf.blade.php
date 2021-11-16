<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.stok_barang') }}</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 11px;
            border-left: 0;
            margin-bottom: 1em;
        }

        table td,
        table th,
        table tfoot {
            border: 1px solid black;
            padding: 3px;
            border-left: 0px solid;
            border-right: 0px solid;
        }

        /* table tr:nth-child(even) {
            background-color: #F2F2F2;
        } */

        table th,
        table tfoot {
            padding-top: 8px;
            padding-bottom: 8px;
            text-align: left;
            /* background-color: #158CBA; */
            color: black;
        }

        p,
        h4 {
            line-height: 8px;
        }

        small {
            font-size: 12px;
        }

        .garis {
            height: 3px;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
        }

    </style>
</head>

<body>
    <div>
        <center>
            <h3 style="margin-bottom: 0px">{{ $toko->nama }}</h3>
            <p>{{ $toko->deskripsi }}</p>
            <p>{{ $toko->alamat . ', ' . $toko->kota }}</p>
            <p>Email: {{ $toko->email }} | Website: {{ $toko->website ? $toko->website : '-' }}</p>
            <p>{{ $toko->telp1 . ' / ' . $toko->telp2 }}</p>
        </center>

        {{-- <hr style="margin-bottom: 15px"> --}}
        <div class="garis"></div>

        <center>
            <h4>{{ trans('dashboard.laporan.stok_barang') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-bottom: 1em;">
            <thead>
                <tr>
                    <th width="15">No.</th>
                    <th>Barang</th>
                    <th>Gudang</th>
                    <th width="30">Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grandtotal = 0;
                    $total_qty = 0;
                    $total_harga = 0;
                @endphp
                @forelse ($laporan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->barang->kode . ' - ' . $item->barang->nama }}</td>
                        <td>{{ $item->pembelian->gudang->nama }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>
                            {{ $item->pembelian->matauang->kode }}
                            {{ number_format($item->harga, 2, '.', ',') }}
                        </td>
                        <td>
                            {{ $item->pembelian->matauang->kode }}
                            {{ number_format($item->gross, 2, '.', ',') }}
                        </td>
                    </tr>
                    @php
                        $grandtotal += $item->gross;
                        $total_qty += $item->qty;
                        $total_harga += $item->harga;
                    @endphp
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total</th>
                    <th>
                        {{ $total_qty }}
                    </th>
                    <th>
                        @if (count($laporan) > 0)
                            {{ $item->pembelian->matauang->kode }}
                        @endif
                        {{ number_format($total_harga, 2, '.', ',') }}
                    </th>
                    <th>
                        @if (count($laporan) > 0)
                            {{ $item->pembelian->matauang->kode }}
                        @endif
                        {{ number_format($grandtotal, 2, '.', ',') }}
                    </th>
                </tr>
            </tfoot>
        </table>

        <small>
            <strong>
                @if (request()->query('per_tanggal'))
                    Per Tanggal:
                    {{ date('d F Y', strtotime(request()->query('per_tanggal'))) }}
                @endif
            </strong>
        </small>
    </div>

</body>

</html>
