<?php

use App\Models\Status_permohonan;
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
        Schema::table('status_permohonans', function (Blueprint $table) {
            //
        });

        $statuses = [
                [
                    'name' => 'NPHD Sesuai', 
                    'description' => 'NPHD yang disampaikan sesuai.',
                    'status_button' => '', 
                    'action_buttons' => '',
                ]
            ];

            foreach ($statuses as $status) {
                Status_permohonan::create(
                    [
                        'name' => $status['name'],
                        'description' => $status['description'],
                        'status_button' => $status['status_button'],
                        'action_buttons' => $status['action_buttons'],
                    ]
                );
            }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('status_permohonans', function (Blueprint $table) {
            //
        });
    }
};
