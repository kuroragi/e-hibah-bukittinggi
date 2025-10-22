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
        Schema::create('skpd_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_skpd');
            $table->string('nama_pimpinan');
            $table->string('jabatan');
            $table->text('alamat_pimpinan')->nullable();
            $table->string('hp_pimpinan')->nullable();
            $table->string('email_pimpinan')->nullable();
            $table->text('perhatian_nphd')->nullable();
            $table->text('rekening_anggaran')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('skpd_details');
    }
};
