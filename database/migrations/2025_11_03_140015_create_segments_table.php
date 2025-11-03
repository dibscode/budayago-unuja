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
        Schema::create('segments', function (Blueprint $table) { 
        $table->id();
        $table->foreignId('id_budaya')->constrained('budayas')->onDelete('cascade');
        $table->integer('urutan');
        $table->string('judul_segment')->nullable();
        $table->string('video_url')->nullable();
        $table->text('teks_narasi')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segments');
    }
};
