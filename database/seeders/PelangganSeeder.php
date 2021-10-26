<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pelanggan::create([
            'kode' => 'CUS1',
            'nama_pelanggan' => 'Alphonse Elric',
            'npwp' => '76786786123',
            'nppkp' => '',
            'tgl_pkp' => now(),
            'alamat' => 'Cengkareng',
            'kota' => 'Jakarta',
            'kode_pos' => '',
            'telp1' => '',
            'telp2' => '',
            'nama_kontak' => '',
            'telp_kontak' => '',
            'top' => 90,
            'status' => 'Y',
            'area_id' => 1,
            'limit' => 1000000,
        ]);
    }
}
