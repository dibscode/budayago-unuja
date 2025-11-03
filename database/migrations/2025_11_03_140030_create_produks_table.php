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
        Schema::create('produks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id_penjual')->constrained('users')->onDelete('cascade');
        $table->foreignId('id_budaya')->nullable()->constrained('budayas')->onDelete('set null');
        $table->string('nama_produk');
        $table->text('deskripsi')->nullable();
        $table->integer('harga'); 
        $table->string('gambar_url')->nullable();
        $table->integer('stok')->default(0);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
