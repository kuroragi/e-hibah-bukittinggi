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
        Schema::table('urusan_skpds', function (Blueprint $table) {
            $table->string('kepala_urusan')->nullable()->after('nama_urusan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('urusan_skpds', function (Blueprint $table) {
            $table->dropColumn('kepala_urusan');
        });
    }
};
