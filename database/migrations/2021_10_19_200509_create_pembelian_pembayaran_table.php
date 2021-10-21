<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembelianPembayaranTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voidk
     */
    public function up()
    {
        Schema::create('pembelian_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembelian_id')->constrained('pembelian')->onDelete('cascade');
            $table->foreignId('bank_id')->constrained('bank')->onDelete('cascade');
            $table->foreignId('rekening_bank_id')->constrained('rekening_bank')->onDelete('cascade');
            $table->enum('jenis_pembayaran', ['Cash', 'Transfer', 'Giro']);
            $table->integer('no_cek_giro');
            $table->date('tgl_cek_giro');
            $table->double('bayar', 20, 2);
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
        Schema::dropIfExists('pembelian_payment');
    }
}
