<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('dashboard.laporan.penjualan') }}</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 11px;
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
            <h4>{{ trans('dashboard.laporan.penjualan') }}</h4>
            <p><small>{{ date('d F Y') }}</small></p>
        </center>

        <table style="margin-top: 1em;">
            <thead>
                <tr>
                    <th width="30">No.</th>
                    <th colspan="4">Kode</th>
                    <th colspan="3">Tanggal</th>
                    <th colspan="4">Gudang</th>
                    <th colspan="3">Pelanggan</th>
                    <th colspan="3">Salesman</th>
                    <th>Rate</th>
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
                        <th colspan="4">{{ $item->kode }}</th>
                        <th colspan="3">{{ $item->tanggal->format('d F Y') }}</th>
                        <th colspan="4">{{ $item->gudang->nama }}</th>
                        <th colspan="3">
                            {{ $item->pelanggan->nama_pelanggan }}
                        </th>
                        <th colspan="3">
                            {{ $item->salesman->nama }}
                        </th>
                        <th>{{ $item->rate }}</th>
                    </tr>
                    <tr>
                        <th></th>
                        <th colspan="7">Barang</th>
                        <th>Qty</th>
                        <th colspan="3">Harga</th>
                        <th>Disc</th>
                        <th>PPN</th>
                        <th>PPH</th>
                        <th>B.Msk</th>
                        <th>Clr.Fee</th>
                        <th colspan="2">Subtotal</th>
                    </tr>
                    @foreach ($item->penjualan_detail as $detail)
                        <tr>
                            <td></td>
                            <td colspan="7">
                                {{ $detail->barang->kode . ' - ' . $detail->barang->nama }}
                            </td>
                            <td>{{ $detail->qty }}</td>
                            <td colspan="3">
                                {{ $item->matauang->kode . ' ' . number_format($detail->harga) }}
                            </td>
                            <td>
                                {{ $item->matauang->kode . ' ' . number_format($detail->diskon) }}
                            </td>
                            <td>
                                {{ $item->matauang->kode . ' ' . number_format($detail->ppn) }}
                            </td>
                            <td>
                                {{ $item->matauang->kode . ' ' . number_format($detail->pph) }}
                            </td>
                            <td>
                                {{ $item->matauang->kode . ' ' . number_format($detail->biaya_masuk) }}
                            </td>
                            <td>
                                {{ $item->matauang->kode . ' ' . number_format($detail->clr_fee) }}
                            </td>
                            <td colspan="2">
                                {{ $item->matauang->kode . ' ' . number_format($detail->netto) }}
                            </td>
                        </tr>
                        @php
                            $total_qty += $detail->qty;
                            $total += $detail->subtotal;
                            $grandtotal += $detail->subtotal;
                        @endphp
                    @endforeach
                    <tr>
                        <th></th>
                        <th colspan="7">Total</th>
                        <th>{{ $total_qty }}</th>
                        <th colspan="3">
                            {{ $item->matauang->kode . ' ' . number_format($item->total_gross) }}
                        </th>
                        <th>
                            {{ $item->matauang->kode . ' ' . number_format($item->total_diskon) }}
                        </th>
                        <th>
                            {{ $item->matauang->kode . ' ' . number_format($item->total_ppn) }}
                        </th>
                        <th>
                            {{ $item->matauang->kode . ' ' . number_format($item->total_pph) }}
                        </th>
                        <th>
                            {{ $item->matauang->kode . ' ' . number_format($item->total_biaya_masuk) }}
                        </th>
                        <th>
                            {{ $item->matauang->kode . ' ' . number_format($item->total_clr_fee) }}
                        </th>
                        <th colspan="2">
                            {{ $item->matauang->kode . ' ' . number_format($item->total_netto) }}
                        </th>
                    </tr>
                @empty
                    <tr>
                        <td colspan="15" class="text-center">Data tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>
