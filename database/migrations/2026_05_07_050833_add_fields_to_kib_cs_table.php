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
        Schema::table('kib_cs', function (Blueprint $table) {
            $table->string('bertingkat')->nullable()->after('luas_bangunan');
            $table->date('tanggal_kontrak')->nullable()->after('bertingkat');
            $table->string('nomor_kontrak')->nullable()->after('tanggal_kontrak');
            $table->string('status_tanah')->nullable()->after('alamat');
            $table->string('kode_tanah')->nullable()->after('status_tanah');
            $table->string('asal_usul')->nullable()->after('kode_tanah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kib_cs', function (Blueprint $table) {
            $table->dropColumn(['bertingkat', 'tanggal_kontrak', 'nomor_kontrak', 'status_tanah', 'kode_tanah', 'asal_usul']);
        });
    }
};
