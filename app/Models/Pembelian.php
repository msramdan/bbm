<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'kode',
        'tanggal',
        'supplier_id',
        'matauang_id',
        'pesanan_pembelian_id',
        'gudang_id',
        'bentuk_kepemilikan_stok',
        'rate',
        'keterangan',
        'subtotal',
        'total_ppn',
        'total_pph',
        'total_gross',
        'total_diskon',
        'total_clr_fee',
        'total_biaya_masuk',
        'total_netto',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    // public function getRouteKeyName()
    // {
    //     return 'kode';
    // }

    public function pembelian_detail()
    {
        return $this->hasMany(PembelianDetail::class);
    }

    public function pembelian_pembayaran()
    {
        return $this->hasMany(PembelianPembayaran::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function matauang()
    {
        return $this->belongsTo(Matauang::class);
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class);
    }

    public function pesanan_pembelian()
    {
        return $this->belongsTo(PesananPembelian::class);
    }
}
