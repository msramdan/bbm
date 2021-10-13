<?php

namespace Database\Seeders;

use App\Models\RekeningBank;
use Illuminate\Database\Seeder;

class RekeningBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RekeningBank::create([
            'kode' => 'REK-1',
            'bank_id' => 1, //BCA
            'nama_rekening' => 'Budi',
            'nomor_rekening' => '1230984312312',
            'status' => 'Y'
        ]);
    }
}
