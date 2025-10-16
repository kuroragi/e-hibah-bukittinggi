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
        if(!Schema::hasColumn('perbaikan_rabs', 'subtotal')){
            Schema::table('perbaikan_rabs', function (Blueprint $table) {
                $table->bigInteger('subtotal')->nullable()->default(0)->after('nama_kegiatan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perbaikan_rabs', function (Blueprint $table) {
            $table->dropColumn('subtotal');
        });
    }
};
