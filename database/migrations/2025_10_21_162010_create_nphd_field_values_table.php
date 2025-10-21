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
        Schema::create('nphd_field_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_lembaga')->nullable();
            $table->unsignedBigInteger('id_skpd')->nullable();
            $table->string('field_name');
            $table->text('field_value');
            $table->string('field_label');
            $table->string('field_type');
            $table->boolean('is_requires')->default(true);
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
        Schema::dropIfExists('nphd_field_values');
    }
};
