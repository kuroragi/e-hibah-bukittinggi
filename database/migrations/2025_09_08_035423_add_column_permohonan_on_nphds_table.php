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
        Schema::table('nphds', function (Blueprint $table) {
            $table->string('no_permohonan')->after('nilai_disetujui');
            $table->date('tanggal_permohonan')->after('no_permohonan');
            $table->string('file_permohonan')->after('tanggal_permohonan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nphds', function (Blueprint $table) {
            $table->dropColumn('no_permohonan');
            $table->dropColumn('tanggal_permohonan');
            $table->dropColumn('file_permohonan');
        });
    }
};
