<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skpi_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_skpi_id')->constrained('kategori_skpis')->onDelete('cascade');
            $table->foreignId('sub_kategori_skpi_id')->constrained('sub_kategori_skpis')->onDelete('cascade');
            $table->string('nama_kegiatan');
            $table->string('nama_kegiatan_en')->nullable();
            $table->string('attachment_url');
            $table->enum('status', ['draft', 'submitted', 'accepted', 'rejected'])->default('draft');
            $table->text('catatan_dosen')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skpi_mahasiswas');
    }
};
