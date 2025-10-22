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
        Schema::table('skpds', function (Blueprint $table) {
            $table->text('deskripsi')->after('name')->nullable();
            $table->text('alamat')->after('deskripsi')->nullable();
            $table->string('telp')->after('alamat')->nullable();
            $table->string('email')->after('telp')->nullable();
            $table->string('fax')->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skpds', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
            $table->dropColumn('alamat');
            $table->dropColumn('telp');
            $table->dropColumn('email');
            $table->dropColumn('fax');
        });
    }
};
