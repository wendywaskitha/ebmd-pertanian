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
        Schema::table('kib_bs', function (Blueprint $table) {
            $table->string('ukuran')->nullable()->after('tipe');
            $table->string('nomor_rangka')->nullable()->after('nomor_seri');
            $table->string('nomor_bpkb')->nullable()->after('nomor_polisi');
            $table->string('asal_usul')->nullable()->after('tahun_pembelian');
            $table->string('ruang_penyimpanan')->nullable()->after('asal_usul');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kib_bs', function (Blueprint $table) {
            $table->dropColumn(['ukuran', 'nomor_rangka', 'nomor_bpkb', 'asal_usul', 'ruang_penyimpanan']);
        });
    }
};
