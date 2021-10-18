<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Matauang;
use App\Models\SatuanBarang;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BarangFactory extends Factory
{
    private static $no = 1;

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Barang::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $kategori = Kategori::latest('id')->first();
        $satuan = SatuanBarang::latest('id')->first();
        $matauang = Matauang::latest('id')->first();

        return [
            'kode' => strtoupper(Str::random(rand(1, 5))),
            'nama' => 'Barang ' . self::$no++,
            'jenis' => rand(1, 2), //1 barang, 2 paket
            'kategori_id' => rand(1, $kategori->id), //random kateogri id sesuai dengan jumlah data kategori
            'satuan_id' => rand(1, $satuan->id),
            'harga_beli_matauang' => rand(1, $matauang->id),
            'harga_jual_matauang' => rand(1, $matauang->id),
            'harga_beli' => rand(1, 5000),
            'harga_jual' => rand(1, 5000),
            'harga_jual_min' => rand(1, 5000),
            'stok' => rand(1, 30),
            'min_stok' => rand(0, 5),
            'gambar' => 'noimage.png',
            'status' => 'Y',
        ];
    }
}
