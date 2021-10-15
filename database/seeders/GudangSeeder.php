<?php

namespace Database\Seeders;

use App\Models\Gudang;
use Illuminate\Database\Seeder;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gudang::create([
            'kode' => 'KDA',
            'nama' => 'Gudang bekasi',
            'status' => 'Y',
            'gudang_penjualan' => 1
        ]);

        Gudang::create([
            'kode' => 'LOL',
            'nama' => 'Gudang bogor',
            'status' => 'Y',
            'gudang_penjualan' => 1
        ]);
    }
}
