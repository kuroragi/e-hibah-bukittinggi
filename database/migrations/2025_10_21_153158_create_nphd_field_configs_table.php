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
        Schema::create('nphd_field_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_config');
            $table->string('label');
            $table->string('name');
            $table->string('type');
            $table->text('options')->nullable();
            $table->boolean('is_required')->default(true);
            $table->integer('order')->nullable()->default(1);
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
        Schema::dropIfExists('nphd_field_configs');
    }
};
