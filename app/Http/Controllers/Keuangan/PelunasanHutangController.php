<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePelunasanHutangRequest;
use App\Models\{PelunasanHutang, Pembelian, PembelianPembayaran};
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PelunasanHutangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create pelunasan hutang')->only('create');
        $this->middleware('permission:read pelunasan hutang')->only('index');
        $this->middleware('permission:edit pelunasan hutang')->only('edit');
        $this->middleware('permission:detail pelunasan hutang')->only('show');
        $this->middleware('permission:update pelunasan hutang')->only('update');
        $this->middleware('permission:delete pelunasan hutang')->only('delete');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $pelunasan = PelunasanHutang::with('pembelian', 'pembelian.supplier', 'pembelian.matauang');

            return DataTables::of($pelunasan)
                ->addIndexColumn()
                ->addColumn('action', 'keuangan.pelunasan.hutang.data-table.action')
                ->addColumn('saldo_hutang', function ($row) {
                    return number_format($row->pembelian->total_netto);
                })
                ->addColumn('bayar', function ($row) {
                    return number_format($row->bayar);
                })
                ->addColumn('kode_pembelian', function ($row) {
                    return $row->pembelian->kode;
                })
                ->addColumn('supplier', function ($row) {
                    return  $row->pembelian->supplier ? $row->pembelian->supplier->nama_supplier : 'Tanpa Supplier';
                })
                ->addColumn('matauang', function ($row) {
                    return $row->pembelian->matauang->nama;
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

        return view('keuangan.pelunasan.hutang.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('keuangan.pelunasan.hutang.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePelunasanHutangRequest $request)
    {
        $attr = $request->validated();
        $attr['pembelian_id'] = $request->pembelian;
        $attr['bank_id'] = $request->bank;
        $attr['rekening_bank_id'] = $request->rekening;

        $pelunasanHutang =  PelunasanHutang::create($attr);

        $pelunasanHutang->pembelian->update(['status' => 'Lunas']);
        $pelunasanHutang->pembelian->pembelian_pembayaran()->create([
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'bank_id' => $request->bank,
            'rekening_bank_id' => $request->rekening,
            'tgl_cek_giro' => $request->tgl_cek_giro,
            'no_cek_giro' => $request->no_cek_giro,
            'bayar' => $request->bayar,
        ]);

        Alert::success('Simpan Data', 'Berhasil');

        return redirect()->route('pelunasan-hutang.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PelunasanHutang  $pelunasanHutang
     * @return \Illuminate\Http\Response
     */
    public function show(PelunasanHutang $pelunasanHutang)
    {
        $pelunasanHutang->load('pembelian', 'pembelian.supplier', 'pembelian.matauang');

        return view('keuangan.pelunasan.hutang.show', compact('pelunasanHutang'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PelunasanHutang  $pelunasanHutang
     * @return \Illuminate\Http\Response
     */
    public function edit(PelunasanHutang $pelunasanHutang)
    {
        $pelunasanHutang->load('pembelian', 'pembelian.supplier', 'pembelian.matauang');

        return view('keuangan.pelunasan.hutang.edit', compact('pelunasanHutang'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PelunasanHutang  $pelunasanHutang
     * @return \Illuminate\Http\Response
     */
    public function update(StorePelunasanHutangRequest $request, PelunasanHutang $pelunasanHutang)
    {
        $attr = $request->validated();
        $attr['pembelian_id'] = $request->pembelian;
        $attr['bank_id'] = $request->bank;
        $attr['rekening_bank_id'] = $request->rekening;

        // hapus pembayaran lama
        $pembayaranLama = PembelianPembayaran::where('pembelian_id', $pelunasanHutang->pembelian_id)->first();

        if ($pembayaranLama) {
            $pembayaranLama->pembelian()->update(['status' => 'Belum Lunas']);

            $pembayaranLama->delete();
        }

        $pelunasanHutang->update($attr);

        $pelunasanHutang->pembelian->update(['status' => 'Lunas']);

        // insert pembayaran baru
        $pelunasanHutang->pembelian->pembelian_pembayaran()->create([
            'jenis_pembayaran' => $request->jenis_pembayaran,
            'bank_id' => $request->bank,
            'rekening_bank_id' => $request->rekening,
            'tgl_cek_giro' => $request->tgl_cek_giro,
            'no_cek_giro' => $request->no_cek_giro,
            'bayar' => $request->bayar,
        ]);

        Alert::success('Update Data', 'Berhasil');

        return redirect()->route('pelunasan-hutang.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PelunasanHutang  $pelunasanHutang
     * @return \Illuminate\Http\Response
     */
    public function destroy(PelunasanHutang $pelunasanHutang)
    {
        $pelunasanHutang->pembelian->update(['status' => 'Belum Lunas']);

        $pelunasanHutang->pembelian->pembelian_pembayaran()->delete();

        $pelunasanHutang->delete();

        Alert::success('Hapus Data', 'Berhasil');

        return back();
    }

    protected function getPembelianYgBelumLunas($id)
    {
        abort_if(!request()->ajax(), 404);

        $pembelianBelumLunas = Pembelian::with('supplier', 'matauang')->findOrFail($id);

        return response()->json($pembelianBelumLunas, 200);
    }

    protected function generateKode($tanggal)
    {
        abort_if(!request()->ajax(), 404);

        $checkLatestKode = PelunasanHutang::whereMonth('tanggal', date('m', strtotime($tanggal)))->whereYear('tanggal', date('Y', strtotime($tanggal)))->latest()->first();

        if ($checkLatestKode == null) {
            $kode = 'APPAY-' . date('Ym', strtotime($tanggal)) . '0000' . 1;
        } else {
            // hapus "APPAY-" dan ambil angka buat ditambahin
            $onlyNumberKode = Str::after($checkLatestKode->kode, 'APPAY-');

            $kode =  'APPAY-' . intval($onlyNumberKode) + 1;
        }

        return response()->json($kode, 200);
    }
}
