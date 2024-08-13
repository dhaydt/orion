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
        Schema::create('running_times', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->dateTime('waktu_mulai')->nullable();
            $table->dateTime('waktu_selesai')->nullable();
            $table->string('nama_penyewa')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('nomor_meja');
            $table->integer('id_user');
            $table->integer('id_member')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('running_times');
    }
};
