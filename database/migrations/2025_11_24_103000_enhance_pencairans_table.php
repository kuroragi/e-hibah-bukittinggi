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
        Schema::table('pencairans', function (Blueprint $table) {
            // Add missing columns
            $table->integer('tahap_pencairan')->default(1)->after('jumlah_pencairan');
            $table->text('keterangan')->nullable()->after('bukti');
            
            // Add document fields for disbursement
            $table->string('file_lpj')->nullable()->after('keterangan'); // Laporan Pertanggungjawaban
            $table->string('file_realisasi')->nullable()->after('file_lpj'); // Bukti Realisasi
            $table->string('file_dokumentasi')->nullable()->after('file_realisasi'); // Dokumentasi Kegiatan
            $table->string('file_kwitansi')->nullable()->after('file_dokumentasi'); // Kwitansi
            
            // Change status enum to be more comprehensive
            $table->enum('status', ['diajukan', 'diverifikasi', 'disetujui', 'ditolak', 'dicairkan'])->default('diajukan')->change();
            
            // Add verification fields
            $table->unsignedBigInteger('verified_by')->nullable()->after('status');
            $table->timestamp('verified_at')->nullable()->after('verified_by');
            $table->text('catatan_verifikasi')->nullable()->after('verified_at');
            
            // Add approval fields
            $table->unsignedBigInteger('approved_by')->nullable()->after('catatan_verifikasi');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('catatan_approval')->nullable()->after('approved_at');
            
            // Foreign keys
            $table->foreign('verified_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pencairans', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropForeign(['approved_by']);
            
            $table->dropColumn([
                'tahap_pencairan',
                'keterangan',
                'file_lpj',
                'file_realisasi',
                'file_dokumentasi',
                'file_kwitansi',
                'verified_by',
                'verified_at',
                'catatan_verifikasi',
                'approved_by',
                'approved_at',
                'catatan_approval',
            ]);
        });
    }
};
