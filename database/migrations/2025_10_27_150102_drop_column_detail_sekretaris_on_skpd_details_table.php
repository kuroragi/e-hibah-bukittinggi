<?php

use App\Models\Skpd;
use App\Models\SkpdDetail;
use App\Models\UrusanSkpd;
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
        Schema::table('skpd_details', function (Blueprint $table) {
            $table->dropColumn('nip_sekretaris');
            $table->dropColumn('jabatan_sekretaris');
            $table->dropColumn('golongan_sekretaris');
            $table->dropColumn('alamat_sekretaris');
            $table->dropColumn('hp_sekretaris');
            $table->dropColumn('email_sekretaris');
        });

        $skpd = Skpd::all();
        $skpd_detail = SkpdDetail::all();
        if(!$skpd_detail->count() > 0){
            foreach ($skpd as $key => $item) {
                SkpdDetail::create(['id_skpd' => $item->id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skpd_details', function (Blueprint $table) {
            $table->string('nip_sekretaris')->nullable();
            $table->string('jabatan_sekretaris')->nullable();
            $table->string('golongan_sekretaris')->nullable();
            $table->text('alamat_sekretaris')->nullable();
            $table->string('hp_sekretaris')->nullable();
            $table->string('email_sekretaris')->nullable();
        });
    }
};
