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
        Schema::create('nphd_lembagas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_lembaga');
            $table->string('nomor_pengukuhan')->nullable();
            $table->date('tanggal_pengukuhan')->nullable();
            $table->string('tentang_pengukuhan')->nullable();
            $table->string('pemberi_amanat')->nullable();
            $table->string('masa_bakti')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('uraian')->nullable();
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
        Schema::dropIfExists('nphd_lembagas');
    }
};
