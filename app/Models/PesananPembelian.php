<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesananPembelian extends Model
{
    use HasFactory;

    protected $table = 'pesanan_pembelian';

    protected $casts = ['tanggal' => 'date'];

    protected $fillable = [
        'kode',
        'tanggal',
        'supplier_id',
        'matauang_id',
        'kepemilikan_stok',
        'rate',
        'keterangan'
    ];

    public function pesanan_pembelian_detail()
    {
        return $this->hasMany(PesananPembelianDetail::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function matauang()
    {
        return $this->belongsTo(Matauang::class);
    }
}
