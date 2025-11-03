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
        Schema::create('budayas', function (Blueprint $table) { 
        $table->id();
        $table->string('nama_budaya');
        $table->string('provinsi', 100)->nullable();
        $table->text('deskripsi')->nullable();
        $table->string('koordinat_lat', 50)->nullable();
        $table->string('koordinat_lng', 50)->nullable();
        $table->string('video_url')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('budayas');
    }
};
