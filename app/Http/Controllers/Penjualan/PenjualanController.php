<?php

namespace App\Http\Controllers\Penjualan;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\PenjualanPembayaran;
use App\Models\RekeningBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $penjualan = Penjualan::with('gudang', 'pelanggan', 'salesman', 'matauang')->withCount('penjualan_detail');

            return Datatables::of($penjualan)
                ->addIndexColumn()
                ->addColumn('action', 'penjualan.penjualan.data-table.action')
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('matauang', function ($row) {
                    return $row->matauang->nama;
                })
                ->addColumn('pelanggan', function ($row) {
                    return $row->pelanggan->nama_pelanggan;
                })
                ->addColumn('gudang', function ($row) {
                    return $row->gudang->nama;
                })
                ->addColumn('salesman', function ($row) {
                    return $row->salesman->nama;
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->penjualan_detail_count;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->matauang->kode . ' ' . number_format($row->total_penjualan);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('penjualan.penjualan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('penjualan.penjualan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $penjualan = Penjualan::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'matauang_id' => $request->matauang,
                'gudang_id' => $request->gudang,
                'pelanggan_id' => $request->pelanggan,
                'salesman_id' => $request->salesman,
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'rate' => $request->rate,
                'alamat' => $request->alamat,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_penjualan' => $request->total_penjualan,
                'total_biaya_kirim' => $request->total_biaya_kirim,
                'total_netto' => $request->total_netto,
            ]);

            foreach ($request->barang as $i => $value) {
                $penjualanDetail[] = new PenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'ppn' => $request->ppn[$i],
                    'netto' => $request->netto[$i],
                ]);
            }

            // kalo user isi jenis pembayaran dan bayar berarti di ga ngutag
            if ($request->jenis_pembayaran && $request->bayar) {
                foreach ($request->bank as $i => $value) {
                    $pembayaran[] = new PenjualanPembayaran([
                        'jenis_pembayaran' => $request->jenis_pembayaran[$i],
                        'bank_id' => $request->bank[$i],
                        'rekening_bank_id' => $request->rekening[$i],
                        'tgl_cek_giro' => $request->tgl_cek_giro[$i],
                        'no_cek_giro' => $request->no_cek_giro[$i],
                        'bayar' => $request->bayar[$i],
                    ]);
                }

                $penjualan->penjualan_pembayaran()->saveMany($pembayaran);
            }

            $penjualan->penjualan_detail()->saveMany($penjualanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function show(Penjualan $penjualan)
    {
        $penjualan->load('penjualan_detail', 'gudang', 'pelanggan', 'salesman', 'matauang');

        return view('penjualan.penjualan.show', compact('penjualan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penjualan $penjualan)
    {
        $penjualan->load('penjualan_detail', 'gudang', 'pelanggan', 'salesman', 'matauang');

        return view('penjualan.penjualan.edit', compact('penjualan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penjualan $penjualan)
    {
        DB::transaction(function () use ($request, $penjualan) {
            $penjualan->update([
                'kode' => $request->kode,
                'gudang_id' => $request->gudang,
                'pelanggan_id' => $request->pelanggan,
                'salesman_id' => $request->salesman,
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'alamat' => $request->alamat,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_penjualan' => $request->total_penjualan,
                'total_biaya_kirim' => $request->total_biaya_kirim,
                'total_netto' => $request->total_netto,
            ]);

            foreach ($request->barang as $i => $value) {
                $penjualanDetail[] = new PenjualanDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'ppn' => $request->ppn[$i],
                    'netto' => $request->netto[$i],
                ]);
            }

            // hapus list lama
            $penjualan->penjualan_pembayaran()->delete();

            // kalo user isi jenis pembayaran dan bayar berarti di ga ngutag
            if ($request->jenis_pembayaran && $request->bayar) {
                foreach ($request->bank as $i => $value) {
                    $pembayaran[] = new PenjualanPembayaran([
                        'jenis_pembayaran' => $request->jenis_pembayaran[$i],
                        'bank_id' => $request->bank[$i],
                        'rekening_bank_id' => $request->rekening[$i],
                        'tgl_cek_giro' => $request->tgl_cek_giro[$i],
                        'no_cek_giro' => $request->no_cek_giro[$i],
                        'bayar' => $request->bayar[$i],
                    ]);
                }

                $penjualan->penjualan_pembayaran()->saveMany($pembayaran);
            }

            $penjualan->penjualan_detail()->delete();

            $penjualan->penjualan_detail()->saveMany($penjualanDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penjualan  $penjualan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penjualan $penjualan)
    {
        $penjualan->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    protected function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = Penjualan::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'SALES-' . date('Ym', strtotime($tanggal)) . '0000' . 1;
        } else {
            // hapus "SALES-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'SALES-');

            $kode =  'SALES-' . intval($onlyNumberKode) + 1;
        }

        return response()->json($kode, 200);
    }

    protected function getRekeningByBankId($id)
    {
        abort_if(!request()->ajax(), 404);

        $rekening = RekeningBank::whereBankId($id)->get();

        return response()->json($rekening, 200);
    }

    protected function getAlamatPelanggan($id)
    {
        abort_if(!request()->ajax(), 404);

        return response()->json(Pelanggan::select('alamat')->findOrFail($id), 200);
    }
}
