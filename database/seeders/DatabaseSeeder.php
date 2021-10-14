<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            MatauangSeeder::class,
            RateMataUangSeeder::class,
            BankSeeder::class,
            RekeningBankSeeder::class,
            SupplierSeeder::class,
            AreaSeeder::class,
            SatuanBarangSeeder::class,
            PelangganSeeder::class,
        ]);
    }
}
