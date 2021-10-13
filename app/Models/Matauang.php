<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matauang extends Model
{
    use HasFactory;
    protected $table = "matauang";

    protected $fillable = [
        'kode',
        'nama',
        'default',
        'status',
    ];

    // public function rate_matauang_asing()
    // {
    //     return $this->belongsTo(RateMataUang::class, 'matauang_id');
    // }

    // public function rate_matauang_default()
    // {
    //     return $this->belongsTo(RateMataUang::class, 'matauang_default');
    // }
}
