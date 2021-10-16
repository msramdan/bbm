<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentPlus extends Model
{
    use HasFactory;

    protected $table = 'adjustment_plus';

    protected $fillable = [
        'kode',
        'tanggal',
        'gudang_id',
        'matauang_id',
        'rate',
        'grand_total'
    ];

    public function adjustment_plus_detail()
    {
        return $this->hasMany(AdjustmentPlusDetail::class);
    }
}
