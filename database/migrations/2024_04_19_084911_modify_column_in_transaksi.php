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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn(['id_running_time', 'waktu_running']);
            $table->bigInteger('total')->default(0);
            $table->bigInteger('potongan')->default(0);
            $table->integer('jumlah_item')->default(0);
            $table->tinyInteger('status_pembayaran')->default(0)->comment('0 = Belum bayar, 1 = Sudah bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            //
        });
    }
};
