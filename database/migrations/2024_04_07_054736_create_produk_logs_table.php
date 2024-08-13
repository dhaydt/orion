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
        Schema::create('produk_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('id_produk');
            $table->text('keterangan')->nullable();
            $table->integer('id_user');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_logs');
    }
};
