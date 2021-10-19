<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesananPembelianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesanan_pembelian', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->date('tanggal');
            $table->foreignId('supplier_id')->constrained('supplier');
            $table->foreignId('matauang_id')->constrained('matauang');
            $table->float('rate');
            $table->string('bentuk_kepemilikan_stok', 20);
            $table->text('keterangan')->nullable();
            $table->float('subtotal');
            $table->float('total_ppn');
            $table->float('total_pph');
            $table->float('total_gross');
            $table->float('total_biaya_masuk');
            $table->float('total_clr_fee');
            $table->float('total_diskon');
            $table->float('total_netto');
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
        Schema::dropIfExists('pesanan_pembelian');
    }
}
