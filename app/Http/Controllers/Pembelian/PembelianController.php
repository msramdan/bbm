<?php

namespace App\Http\Controllers\Pembelian;

use App\Http\Controllers\Controller;
use App\Models\{Bank, Barang, Supplier, Pembelian, Matauang, Gudang, PembelianDetail, PembelianPembayaran, PesananPembelian, RekeningBank};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pembelian = Pembelian::with('pembelian_detail', 'gudang', 'supplier', 'matauang')->withCount('pembelian_detail')->get();

        return view('pembelian.pembelian.index', compact('pembelian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = Barang::get();
        $matauang = Matauang::get();
        $supplier = Supplier::get();
        $gudang = Gudang::get();
        $pesananPembelian = PesananPembelian::get();
        $jenisPembayaran = $this->getJenisPembayaran();
        $bank = Bank::get();

        return view('pembelian.pembelian.create', compact('barang', 'matauang', 'gudang', 'bank', 'supplier', 'pesananPembelian', 'jenisPembayaran'));
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
        $barang = Barang::get();
        // $matauang = Matauang::get();
        $supplier = Supplier::get();
        $gudang = Gudang::get();
        $pesananPembelian = PesananPembelian::get();
        $jenisPembayaran = $this->getJenisPembayaran();
        $bank = Bank::get();

        $pembelian->load('pembelian_detail', 'gudang', 'supplier', 'matauang', 'pembelian_pembayaran', 'pesanan_pembelian');

        return view('pembelian.pembelian.edit', compact('barang', 'gudang', 'bank', 'supplier', 'pesananPembelian', 'jenisPembayaran', 'pembelian'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pembelian  $pembelian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembelian $pembelian)
    {
        //
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

        return redirect()->route('pembelian.index');
    }

    protected function getJenisPembayaran()
    {
        // buat collection/array to collection
        return collect([
            (object)  [
                'id' => 'Cash',
                'nama' => 'Cash'
            ],
            (object)  [
                'id' => 'Transfer',
                'nama' =>  'Transfer',
            ],
            (object) [
                'id' => 'Giro',
                'nama' => 'Giro'
            ]
        ]);
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
