<?php

namespace Database\Seeders;

use App\Models\Salesman;
use Illuminate\Database\Seeder;

class SalesmanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Salesman::create([
            'kode' => 'AND',
            'nama' => 'Andi',
            'commission' => '1',
            'status' => 'Y'
        ]);

        Salesman::create([
            'kode' => 'STV',
            'nama' => 'Steven',
            'commission' => '1',
            'status' => 'Y'
        ]);
    }
}
