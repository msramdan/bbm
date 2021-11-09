<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PelunasanPiutangRequest;
use App\Models\{PelunasanPiutang, Penjualan, PenjualanPembayaran};
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PelunasanPiutangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create pelunasan piutang')->only('create');
        $this->middleware('permission:read pelunasan piutang')->only('index');
        $this->middleware('permission:edit pelunasan piutang')->only('edit');
        $this->middleware('permission:detail pelunasan piutang')->only('show');
        $this->middleware('permission:update pelunasan piutang')->only('update');
        $this->middleware('permission:delete pelunasan piutang')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pelunasan = PelunasanPiutang::with('penjualan', 'penjualan.pelanggan', 'penjualan.matauang');

            return DataTables::of($pelunasan)
                ->addIndexColumn()
                ->addColumn('action', 'keuangan.pelunasan.piutang.data-table.action')
                ->addColumn('saldo_piutang', function ($row) {
                    return number_format($row->penjualan->total_netto);
                })
                ->addColumn('bayar', function ($row) {
                    return number_format($row->bayar);
                })
                ->addColumn('kode_penjualan', function ($row) {
                    return $row->penjualan->kode;
                })
                ->addColumn('pelanggan', function ($row) {
                    return $row->penjualan->pelanggan->nama_pelanggan;
                })
                ->addColumn('matauang', function ($row) {
                    return $row->penjualan->matauang->nama;
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

        return view('keuangan.pelunasan.piutang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keuangan.pelunasan.piutang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PelunasanPiutangRequest $request)
    {
        $attr = $request->validated();
        $attr['penjualan_id'] = $request->penjualan;
        $attr['bank_id'] = $request->bank;
        $attr['rekening_bank_id'] = $request->rekening;

        $pelunasanPiutang = PelunasanPiutang::create($attr);

        $pelunasanPiutang->penjualan->update(['status' => 'Lunas']);
        $pelunasanPiutang->penjualan->penjualan_pembayaran()->create([
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'bank_id' => $request->bank,
            'rekening_bank_id' => $request->rekening,
            'tgl_cek_giro' => $request->tgl_cek_giro,
            'no_cek_giro' => $request->no_cek_giro,
            'bayar' => $request->bayar,
        ]);

        Alert::success('Simpan Data', 'Berhasil');

        return redirect()->route('pelunasan-piutang.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PelunasanPiutang  $pelunasanPiutang
     * @return \Illuminate\Http\Response
     */
    public function show(PelunasanPiutang $pelunasanPiutang)
    {
        $pelunasanPiutang->load('penjualan', 'penjualan.pelanggan', 'penjualan.matauang');

        return view('keuangan.pelunasan.piutang.show', compact('pelunasanPiutang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PelunasanPiutang  $pelunasanPiutang
     * @return \Illuminate\Http\Response
     */
    public function edit(PelunasanPiutang $pelunasanPiutang)
    {
        $pelunasanPiutang->load('penjualan', 'penjualan.pelanggan', 'penjualan.matauang');

        return view('keuangan.pelunasan.piutang.edit', compact('pelunasanPiutang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PelunasanPiutang  $pelunasanPiutang
     * @return \Illuminate\Http\Response
     */
    public function update(PelunasanPiutangRequest $request, PelunasanPiutang $pelunasanPiutang)
    {
        $attr = $request->validated();
        $attr['penjualan_id'] = $request->penjualan;
        $attr['bank_id'] = $request->bank;
        $attr['rekening_bank_id'] = $request->rekening;

        // hapus pembayaran lama
        $pembayaranLama = PenjualanPembayaran::where('penjualan_id', $pelunasanPiutang->penjualan_id)->first();

        if ($pembayaranLama) {
            $pembayaranLama->penjualan()->update(['status' => 'Belum Lunas']);

            $pembayaranLama->delete();
        }

        $pelunasanPiutang->update($attr);

        $pelunasanPiutang->penjualan->update(['status' => 'Lunas']);

        // insert pembayaran baru
        $pelunasanPiutang->penjualan->penjualan_pembayaran()->create([
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'bank_id' => $request->bank,
            'rekening_bank_id' => $request->rekening,
            'tgl_cek_giro' => $request->tgl_cek_giro,
            'no_cek_giro' => $request->no_cek_giro,
            'bayar' => $request->bayar,
        ]);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('pelunasan-piutang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PelunasanPiutang  $pelunasanPiutang
     * @return \Illuminate\Http\Response
     */
    public function destroy(PelunasanPiutang $pelunasanPiutang)
    {
        $pelunasanPiutang->penjualan->update(['status' => 'Belum Lunas']);

        $pelunasanPiutang->penjualan->penjualan_pembayaran()->delete();

        $pelunasanPiutang->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    protected function getPenjualanYgBelumLunas($id)
    {
        abort_if(!request()->ajax(), 404);

        $penjualanBelumLunas = Penjualan::with('pelanggan', 'matauang')->findOrFail($id);

        return response()->json($penjualanBelumLunas, 200);
    }

    protected function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = PelunasanPiutang::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'ARPAY-' . date('Ym', strtotime($tanggal)) . '00001';
        } else {
            // hapus "ARPAY-" dan ambil angka buat ditambahin
            $onlyNumberKode = \Str::after($checkLatestKode->kode, 'ARPAY-');

            $kode =  'ARPAY-' . (intval($onlyNumberKode) + 1);
        }

        return response()->json($kode, 200);
    }
}
