<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_produks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_produk');
            $table->integer('id_transaksi');
            $table->bigInteger('harga');
            $table->integer('jumlah');
            $table->bigInteger('sub_total');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_produks');
    }
};
