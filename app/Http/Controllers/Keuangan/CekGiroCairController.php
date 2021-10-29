<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Http\Requests\CekGiroCairRequest;
use App\Models\{CekGiro, CekGiroCair};
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class CekGiroCairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $cekGiroCair = CekGiroCair::with('cek_giro', 'cek_giro.pembelian', 'cek_giro.pembelian.pembelian_pembayaran', 'cek_giro.penjualan', 'cek_giro.penjualan.penjualan_pembayaran');

            return DataTables::of($cekGiroCair)
                ->addIndexColumn()
                ->addColumn('action', 'keuangan.cek-giro.cair.data-table.action')
                ->addColumn('nilai_cek_giro', function ($row) {
                    if ($row->cek_giro->penjualan) {
                        return number_format($row->cek_giro->penjualan->penjualan_pembayaran[0]->bayar);
                    } else {
                        return number_format($row->cek_giro->pembelian->pembelian_pembayaran[0]->bayar);
                    }
                })
                ->addColumn('no_cek_giro', function ($row) {
                    if ($row->cek_giro->penjualan) {
                        return $row->cek_giro->penjualan->penjualan_pembayaran[0]->no_cek_giro;
                    } else {
                        return $row->cek_giro->pembelian->pembelian_pembayaran[0]->no_cek_giro;
                    }
                })
                ->addColumn('jenis_cek', function ($row) {
                    return strtoupper($row->cek_giro->jenis_cek);
                })
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('d F Y H:i');
                })
                ->addColumn('tanggal', function ($row) {
                    return $row->tanggal->format('d F Y');
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('d F Y H:i');
                })
                ->toJson();
        }

        return view('keuangan.cek-giro.cair.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keuangan.cek-giro.cair.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CekGiroCairRequest $request)
    {
        $attr = $request->validated();
        $attr['bank_id'] = $request->bank;
        $attr['rekening_bank_id'] = $request->rekening;

        $cekGiro = CekGiro::with('pembelian', 'penjualan')->findOrFail($request->no_cek_giro);

        if ($cekGiro->pembelian) {
            $cekGiro->pembelian->update(['status' => 'Lunas']);
        }

        if ($cekGiro->penjualan) {
            $cekGiro->penjualan->update(['status' => 'Lunas']);
        }

        $cekGiro->update(['status' => 'Cair']);

        $cekGiro->pencairan_cek()->create($attr);

        Alert::success('Simpan Data', 'Berhasil');

        return redirect()->route('cek-giro-cair.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CekGiroCair  $cekGiroCair
     * @return \Illuminate\Http\Response
     */
    public function show(CekGiroCair $cekGiroCair)
    {
        $cekGiroCair->load(
            'cek_giro',
            'cek_giro.pembelian',
            'cek_giro.pembelian.matauang',
            'cek_giro.pembelian.supplier',
            'cek_giro.pembelian.pembelian_pembayaran',
            'cek_giro.penjualan',
            'cek_giro.penjualan.matauang',
            'cek_giro.penjualan.pelanggan',
            'cek_giro.penjualan.penjualan_pembayaran',
            'rekening',
            'bank'
        );

        return view('keuangan.cek-giro.cair.show', compact('cekGiroCair'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CekGiroCair  $cekGiroCair
     * @return \Illuminate\Http\Response
     */
    public function edit(CekGiroCair $cekGiroCair)
    {
        $cekGiroCair->load(
            'cek_giro',
            'cek_giro.pembelian',
            'cek_giro.pembelian.matauang',
            'cek_giro.pembelian.supplier',
            'cek_giro.pembelian.pembelian_pembayaran',
            'cek_giro.penjualan',
            'cek_giro.penjualan.matauang',
            'cek_giro.penjualan.pelanggan',
            'cek_giro.penjualan.penjualan_pembayaran',
            'rekening',
            'bank'
        );

        return view('keuangan.cek-giro.cair.edit', compact('cekGiroCair'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CekGiroCair  $cekGiroCair
     * @return \Illuminate\Http\Response
     */
    public function update(CekGiroCairRequest $request, CekGiroCair $cekGiroCair)
    {
        $attr = $request->validated();
        $attr['bank_id'] = $request->bank;
        $attr['rekening_bank_id'] = $request->rekening;
        $attr['cek_giro_id'] = $request->no_cek_giro;

        // dump($request->no_cek_giro);
        // dump($cekGiroCair->cek_giro->id);
        // die;

        // hapus data lama
        if ($cekGiroCair->cek_giro->pembelian) {
            $cekGiroCair->cek_giro->pembelian->update(['status' => 'Belum Lunas']);
        }

        if ($cekGiroCair->cek_giro->penjualan) {
            $cekGiroCair->cek_giro->penjualan->update(['status' => 'Belum Lunas']);
        }

        // ubah cek giro dari cair menjadi belum lunas
        $cekGiroCair->cek_giro()->update(['status' => 'Belum Lunas']);
        // end hapus data lama


        // insert data baru
        $cekGiroBaru = CekGiro::with('pembelian', 'penjualan')->findOrFail($request->no_cek_giro);

        $cekGiroBaru->update(['status' => 'Cair']);

        if ($cekGiroBaru->pembelian) {
            $cekGiroBaru->pembelian->update(['status' => 'Lunas']);
        }

        if ($cekGiroBaru->penjualan) {
            $cekGiroBaru->penjualan->update(['status' => 'Lunas']);
        }
        // end insert data baru

        // update pencairan cek
        $cekGiroCair->update($attr);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('cek-giro-cair.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CekGiroCair  $cekGiroCair
     * @return \Illuminate\Http\Response
     */
    public function destroy(CekGiroCair $cekGiroCair)
    {
        if ($cekGiroCair->cek_giro->pembelian) {
            $cekGiroCair->cek_giro->pembelian->update(['status' => 'Belum Lunas']);
        } else {
            $cekGiroCair->cek_giro->penjualan->update(['status' => 'Belum Lunas']);
        }

        $cekGiroCair->cek_giro->update(['status' => 'Belum Lunas']);

        $cekGiroCair->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    protected function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = CekGiroCair::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'CHWDL-' . date('Ym', strtotime($tanggal)) . '0000' . 1;
        } else {
            // hapus "CHWDL-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'CHWDL-');

            $kode =  'CHWDL-' . intval($onlyNumberKode) + 1;
        }

        return response()->json($kode, 200);
    }

    protected function getCekGiroById($id)
    {
        abort_if(!request()->ajax(), 404);

        $cekGiro = CekGiro::with(
            'pembelian:id,supplier_id,matauang_id,kode,rate',
            'penjualan:id,pelanggan_id,matauang_id,kode,rate',
            'pembelian.supplier:id,nama_supplier',
            'penjualan.pelanggan:id,nama_pelanggan',
            'penjualan.matauang:id,kode,nama',
            'pembelian.matauang:id,kode,nama',
            'penjualan.penjualan_pembayaran',
            'pembelian.pembelian_pembayaran'
        )->findOrFail($id);

        return response()->json($cekGiro, 200);
    }
}
