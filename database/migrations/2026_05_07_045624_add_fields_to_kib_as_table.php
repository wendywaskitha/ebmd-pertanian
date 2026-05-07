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
        Schema::table('kib_as', function (Blueprint $table) {
            $table->date('tanggal_sertifikat')->nullable()->after('nomor_sertifikat');
            $table->string('penggunaan')->nullable()->after('tanggal_sertifikat');
            $table->text('keterangan')->nullable()->after('penggunaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kib_as', function (Blueprint $table) {
            $table->dropColumn(['tanggal_sertifikat', 'penggunaan', 'keterangan']);
        });
    }
};
