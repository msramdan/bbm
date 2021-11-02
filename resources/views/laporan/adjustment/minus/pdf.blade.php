<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.adjustment_minus') }}</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
            border-left: 0;
        }

        table td,
        table th,
        table tfoot {
            border: 1px solid #dddd;
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
            <h4>{{ trans('dashboard.laporan.adjustment_minus') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table class="table table-striped table-condensed data-table" style="margin-top: 1em;">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th colspan="2">Kode</th>
                    <th colspan="2">Tanggal</th>
                    <th>Gudang</th>
                </tr>
            </thead>
            @php
                $grandtotal = 0;
            @endphp
            <tbody>
                @forelse ($laporan as $item)
                    @php
                        $total_qty = 0;
                        $total = 0;
                    @endphp
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <th colspan="2">{{ $item->kode }}</th>
                        <th colspan="2">{{ $item->tanggal->format('d F Y') }}</th>
                        <th>{{ $item->gudang->nama }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="2">Barang</th>
                        <th colspan="2">Supplier</th>
                        <th>Qty</th>
                    </tr>
                    @foreach ($item->adjustment_minus_detail as $detail)
                        <tr>
                            <td></td>
                            <td colspan="2">
                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                            </td>
                            <td colspan="2">{{ $detail->supplier->nama_supplier }}</td>
                            <td>{{ $detail->qty }}</td>
                        </tr>
                        @php
                            $total_qty += $detail->qty;
                        @endphp
                    @endforeach
                    <tr>
                        <th></th>
                        <th colspan="4">Total</th>
                        <th>{{ $total_qty }}</th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>
