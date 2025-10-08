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
        if(!Schema::hasColumn('rab_permohonans', 'subtotal')){
            Schema::table('rab_permohonans', function (Blueprint $table) {
                $table->string('subtotal')->nullable()->after('nama_kegiatan');
            });
        }

        Schema::dropIfExists('rincian_rabs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
