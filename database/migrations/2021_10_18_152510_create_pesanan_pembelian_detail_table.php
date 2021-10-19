<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananPembelianDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan_pembelian_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_pembelian_id')->constrained('pesanan_pembelian')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang');
            $table->integer('qty');
            $table->float('harga');
            $table->float('diskon_persen')->nullable();
            $table->float('diskon')->nullable();
            $table->float('ppn')->nullable();
            $table->float('pph')->nullable();
            $table->float('biaya_masuk')->nullable();
            $table->float('clr_fee')->nullable();
            $table->float('gross');
            $table->float('netto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan_pembelian_detail');
    }
}
