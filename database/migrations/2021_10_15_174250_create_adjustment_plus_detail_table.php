<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjustmentPlusDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjustment_plus_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('adjustment_plus_id')->constrained('adjustment_plus')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang');
            $table->foreignId('supplier_id')->constrained('supplier');
            $table->string('bentuk_kepemilikan_stok', 20);
            $table->integer('qty');
            $table->float('harga');
            $table->float('subtotal');
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
        Schema::dropIfExists('adjustment_plus_detail');
    }
}
