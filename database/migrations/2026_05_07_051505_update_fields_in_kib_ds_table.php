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
        Schema::table('kib_ds', function (Blueprint $table) {
            $table->string('konstruksi')->nullable()->after('aset_id');
            $table->double('luas')->nullable()->after('panjang');
            $table->date('tanggal_kontrak')->nullable()->after('luas');
            $table->string('nomor_kontrak')->nullable()->after('tanggal_kontrak');
            $table->string('status_tanah')->nullable()->after('nomor_kontrak');
            $table->string('asal_usul')->nullable()->after('status_tanah');
            $table->dropColumn('kondisi_kib_d');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kib_ds', function (Blueprint $table) {
            $table->string('kondisi_kib_d')->nullable()->after('panjang');
            $table->dropColumn(['konstruksi', 'luas', 'tanggal_kontrak', 'nomor_kontrak', 'status_tanah', 'asal_usul']);
        });
    }
};
