<?php

use App\Models\Status_permohonan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
                'name' => 'Diperbaiki', 
                'description' => 'Permohonan telah Diperbaiki oleh Lemabaga.', 
                'status_button' => '', 
                'action_buttons' => json_encode(
                    [
                        [
                            'color' => 'info', 
                            'icon' => 'bi bi-eye', 
                            'url' => 'permohonan.show', 
                            'permission' => 'check'
                        ],
                        [
                            'color' => 'success', 
                            'icon' => 'bi bi-send', 
                            'url' => 'permohonan.send_revisi', 
                            'permission' => 'revised'
                        ],
                        [
                            'color' => 'secondary', 
                            'icon' => 'bi bi-cloud-download-fill', 
                            'url' => 'permohonan.pemberitahuan.download', 
                            'permission' => 'download_pemberitahuan'
                        ]
                    ]
                ),
            ],
            [
                'name' => 'Perbaikan Dikirim', 
                'description' => 'Permohonan telah dikirim dan akan di review.', 
                'status_button' => '', 
                'action_buttons' => json_encode(
                    [
                        [
                            'color' => 'info', 
                            'icon' => 'bi bi-eye', 
                            'url' => 'permohonan.show', 
                            'permission' => 'check'
                        ],
                        [
                            'color' => 'warning', 
                            'icon' => 'bi bi-search', 
                            'url' => 'permohonan.review_revisi', 
                            'permission' => 'review_revisi'
                        ],
                    ]
                ),
            ],
            [
                'name' => 'Perbaikan Diteruskan', 
                'description' => 'Perbaikan Permohonan telah dikirim ke verifikator.', 
                'status_button' => '', 
                'action_buttons' => json_encode(
                    [
                        [
                            'color' => 'info', 
                            'icon' => 'bi bi-eye', 
                            'url' => 'permohonan.show', 
                            'permission' => 'check'
                        ],
                        [
                            'color' => 'warning', 
                            'icon' => 'bi bi-file-check-fill', 
                            'url' => 'permohonan.confirm_revisi', 
                            'permission' => 'confirm_revisi'
                        ],
                    ]
                ),
            ],
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
        DB::table('status_permohonans')
        ->orderBy('id', 'desc')   // urutkan dari paling baru
        ->limit(3)                // ambil 3 terakhir
        ->delete();               // hapus
    }
};
