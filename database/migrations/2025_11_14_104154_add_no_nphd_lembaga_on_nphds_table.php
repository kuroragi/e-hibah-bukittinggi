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
            $table->string('no_nphd')->change('no_nphd_skpd');
            $table->string('no_nphd_lembaga')->nullable()->after('no_nphd');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nphds', function (Blueprint $table) {
            //
        });
    }
};
