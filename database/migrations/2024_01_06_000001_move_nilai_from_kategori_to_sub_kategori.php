<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add nilai column to sub_kategori_skpis
        Schema::table('sub_kategori_skpis', function (Blueprint $table) {
            $table->integer('nilai')->default(0)->after('deskripsi');
        });

        // Remove nilai column from kategori_skpis
        Schema::table('kategori_skpis', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });
    }

    public function down(): void
    {
        // Restore nilai column in kategori_skpis
        Schema::table('kategori_skpis', function (Blueprint $table) {
            $table->integer('nilai')->default(0)->after('nama_en');
        });

        // Remove nilai column from sub_kategori_skpis
        Schema::table('sub_kategori_skpis', function (Blueprint $table) {
            $table->dropColumn('nilai');
        });
    }
};
