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
        Schema::table('kib_fs', function (Blueprint $table) {
            $table->string('bertingkat')->nullable()->after('aset_id');
            $table->date('tanggal_kontrak')->nullable()->after('bertingkat');
            $table->string('status_tanah')->nullable()->after('nilai_kontrak');
            $table->string('asal_usul')->nullable()->after('status_tanah');
            $table->double('sisa_kontrak')->nullable()->after('asal_usul');
            $table->dropColumn(['progress', 'vendor']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kib_fs', function (Blueprint $table) {
            $table->integer('progress')->nullable()->after('aset_id');
            $table->string('vendor')->nullable()->after('nilai_kontrak');
            $table->dropColumn(['bertingkat', 'tanggal_kontrak', 'status_tanah', 'asal_usul', 'sisa_kontrak']);
        });
    }
};
