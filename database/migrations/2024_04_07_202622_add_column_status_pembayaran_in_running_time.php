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
        Schema::table('running_times', function (Blueprint $table) {
            $table->tinyInteger('status_pembayaran')
                ->default(0)
                ->comment('0 = Belum melakukan pembayaran, 1 = sudah melakukan pembayaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('running_times', function (Blueprint $table) {
            //
        });
    }
};
