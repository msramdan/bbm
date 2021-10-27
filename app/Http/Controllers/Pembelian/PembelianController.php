<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\{Pembelian, PembelianDetail, PembelianPembayaran, PesananPembelian, RekeningBank};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create pembelian')->only('create');
        $this->middleware('permission:read pembelian')->only('index');
        $this->middleware('permission:edit pembelian')->only('edit');
        $this->middleware('permission:detail pembelian')->only('show');
        $this->middleware('permission:update pembelian')->only('update');
        $this->middleware('permission:delete pembelian')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pembelian = Pembelian::with('gudang', 'supplier', 'matauang')->withCount('pembelian_detail');

            return Datatables::of($pembelian)
                ->addIndexColumn()
                ->addColumn('action', 'pembelian.pembelian.data-table.action')
                ->addColumn('kode_po', function ($row) {
                    return $row->pesanan_pembelian ? $row->pesanan_pembelian->kode : 'Tanpa P.O';
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('matauang', function ($row) {
                    return $row->matauang->nama;
                })
                ->addColumn('supplier', function ($row) {
                    return $row->supplier ? $row->supplier->nama_supplier : 'Tanpa Supplier';
                })
                ->addColumn('gudang', function ($row) {
                    return $row->gudang->nama;
                })
                ->addColumn('total_barang', function ($row) {
                    return $row->pembelian_detail_count;
                })
                ->addColumn('grand_total', function ($row) {
                    return $row->matauang->kode . ' ' . number_format($row->total_netto);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('pembelian.pembelian.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pembelian.pembelian.create');
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
            $pembelian = Pembelian::create([
                'kode' => $request->kode,
                'tanggal' => $request->tanggal,
                'matauang_id' => $request->matauang,
                'gudang_id' => $request->gudang,
                'supplier_id' => $request->supplier,
                'pesanan_pembelian_id' => $request->kode_po,
                'keterangan' => $request->keterangan,
                'bentuk_kepemilikan_stok' => $request->bentuk_kepemilikan,
                'rate' => $request->rate,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_pph' => $request->total_pph,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_clr_fee' => $request->total_clr_fee,
                'total_biaya_masuk' => $request->total_biaya_masuk,
                'total_netto' => $request->total_netto,
            ]);

            foreach ($request->barang as $i => $value) {
                $pembelianDetail[] = new PembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'biaya_masuk' => $request->biaya_masuk[$i],
                    'clr_fee' => $request->clr_fee[$i],
                    'ppn' => $request->ppn[$i],
                    'pph' => $request->pph[$i],
                    'netto' => $request->netto[$i],
                ]);
            }

            foreach ($request->bank as $i => $value) {
                $pembayaran[] = new PembelianPembayaran([
                    'jenis_pembayaran' => $request->jenis_pembayaran[$i],
                    'bank_id' => $request->bank[$i],
                    'rekening_bank_id' => $request->rekening[$i],
                    'tgl_cek_giro' => $request->tgl_cek_giro[$i],
                    'no_cek_giro' => $request->no_cek_giro[$i],
                    'bayar' => $request->bayar[$i],
                ]);
            }

            $pembelian->pembelian_pembayaran()->saveMany($pembayaran);

            $pembelian->pembelian_detail()->saveMany($pembelianDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function show(Pembelian $pembelian)
    {
        $pembelian->load('pembelian_detail', 'gudang', 'supplier', 'matauang', 'pembelian_pembayaran', 'pesanan_pembelian')->withCount('pembelian_detail', 'pembelian_pembayaran');

        return view('pembelian.pembelian.show', compact('pembelian'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembelian $pembelian)
    {
        $pembelian->load('pembelian_detail', 'gudang', 'supplier', 'matauang', 'pembelian_pembayaran', 'pesanan_pembelian');

        return view('pembelian.pembelian.edit', compact('pembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pembelian = Pembelian::findOrFail($id);

        DB::transaction(function () use ($request, $pembelian) {
            $pembelian->update([
                'gudang_id' => $request->gudang,
                'keterangan' => $request->keterangan,
                'subtotal' => $request->subtotal,
                'total_ppn' => $request->total_ppn,
                'total_pph' => $request->total_pph,
                'total_gross' => $request->total_gross,
                'total_diskon' => $request->total_diskon,
                'total_clr_fee' => $request->total_clr_fee,
                'total_biaya_masuk' => $request->total_biaya_masuk,
                'total_netto' => $request->total_netto,
            ]);

            foreach ($request->barang as $i => $value) {
                $pembelianDetail[] = new PembelianDetail([
                    'barang_id' => $value,
                    'harga' => $request->harga[$i],
                    'qty' => $request->qty[$i],
                    'diskon_persen' => $request->diskon_persen[$i],
                    'diskon' => $request->diskon[$i],
                    'gross' => $request->gross[$i],
                    'biaya_masuk' => $request->biaya_masuk[$i],
                    'clr_fee' => $request->clr_fee[$i],
                    'ppn' => $request->ppn[$i],
                    'pph' => $request->pph[$i],
                    'netto' => $request->netto[$i],
                ]);
            }

            foreach ($request->bank as $i => $value) {
                $pembayaran[] = new PembelianPembayaran([
                    'bank_id' => $request->bank[$i],
                    'rekening_bank_id' => $request->rekening[$i],
                    'tgl_cek_giro' => $request->tgl_cek_giro[$i],
                    'no_cek_giro' => $request->no_cek_giro[$i],
                    'bayar' => $request->bayar[$i],
                ]);
            }

            // hapus list lama
            $pembelian->pembelian_pembayaran()->delete();
            $pembelian->pembelian_detail()->delete();

            // insert list baru
            $pembelian->pembelian_pembayaran()->saveMany($pembayaran);
            $pembelian->pembelian_detail()->saveMany($pembelianDetail);
        });

        return response()->json(['success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembelian $pembelian)
    {
        $pembelian->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    protected function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = Pembelian::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->count();

        if ($checkLatestKode == null) {
            $kode = 'PURCH-' . date('Ym', strtotime($tanggal)) . '0000' . 1;
        } else {
            if ($checkLatestKode < 10) {
                $kode = 'PURCH-' . date('Ym', strtotime($tanggal)) . '0000' . $checkLatestKode + 1;
            } elseif ($checkLatestKode > 10) {
                $kode = 'PURCH-' . date('Ym', strtotime($tanggal)) . '000' . $checkLatestKode + 1;
            } elseif ($checkLatestKode > 100) {
                $kode = 'PURCH-' . date('Ym', strtotime($tanggal)) . '00' . $checkLatestKode + 1;
            } elseif ($checkLatestKode > 1000) {
                $kode = 'PURCH-' . date('Ym', strtotime($tanggal)) . '0' . $checkLatestKode + 1;
            }
        }

        return response()->json($kode, 200);
    }

    protected function getRekeningByBankId($id)
    {
        $rekening = RekeningBank::whereBankId($id)->get();

        return response()->json($rekening, 200);
    }

    protected function getDataPO($id)
    {
        $pesananPembelian = PesananPembelian::with('supplier', 'matauang')->findOrFail($id);

        return response()->json($pesananPembelian, 200);
    }
}
