<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sub_kategori_skpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_skpi_id')->constrained('kategori_skpis')->onDelete('cascade');
            $table->string('nama');
            $table->string('nama_en')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_kategori_skpis');
    }
};
