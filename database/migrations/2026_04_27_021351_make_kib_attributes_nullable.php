<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kib_as', function (Blueprint $table) {
            $table->decimal('luas', 15, 2)->nullable()->change();
            $table->string('status_tanah')->nullable()->change();
        });

        Schema::table('kib_bs', function (Blueprint $table) {
            $table->string('merk')->nullable()->change();
            $table->string('tipe')->nullable()->change();
            $table->string('nomor_seri')->nullable()->change();
            $table->integer('tahun_pembelian')->nullable()->change();
        });

        Schema::table('kib_cs', function (Blueprint $table) {
            $table->decimal('luas_bangunan', 15, 2)->nullable()->change();
            $table->string('alamat')->nullable()->change();
        });

        Schema::table('kib_ds', function (Blueprint $table) {
            $table->decimal('panjang', 15, 2)->nullable()->change();
            $table->string('kondisi_kib_d')->nullable()->change();
        });

        Schema::table('kib_es', function (Blueprint $table) {
            $table->string('jenis')->nullable()->change();
            $table->string('keterangan')->nullable()->change();
        });

        Schema::table('kib_fs', function (Blueprint $table) {
            $table->integer('progress')->nullable()->change();
            $table->decimal('nilai_kontrak', 15, 2)->nullable()->change();
            $table->string('vendor')->nullable()->change();
        });
    }

    public function down(): void
    {
        // No need to revert for this specific task
    }
};
