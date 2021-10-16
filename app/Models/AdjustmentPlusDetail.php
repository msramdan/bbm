<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentPlusDetail extends Model
{
    use HasFactory;

    protected $table = 'adjustment_plus_detail';

    protected $fillable = [
        'adjustment_plus_id',
        'bentuk_kepemilikan_stok',
        'barang_id',
        'supplier_id',
        'qty',
        'harga',
        'subtotal'
    ];


    public function adjustment_plus()
    {
        return $this->belongsTo(AdjustmentPlus::class);
    }
}
