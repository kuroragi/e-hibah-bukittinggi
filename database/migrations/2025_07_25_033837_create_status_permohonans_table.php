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
        Schema::create('status_permohonans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->text('status_button')->nullable();
            $table->text('action_buttons')->nullable();
            $table->timestamps();
        });

        $statuses = [
            [
                'name' => 'Dibuat', 
                'description' => 'Permohonan telah Dibuat oleh Lemabaga.', 
                'status_button' => json_encode([
                    'color' => 'primary', 
                    'text' => 'Lanjutkan Isi Data Pendukung', 
                    'url' => 'permohonan.isi_pendukung', 
                    'permission' => 'view_dukung'
                ]), 
                'action_buttons' => json_encode(
                    [
                    'color' => 'info', 
                    'icon' => 'bi bi-eye', 
                    'url' => 'permohonan.show', 
                    'permission' => 'check'
                    ],
                ),
            ],
            [
                'name' => 'Didukung', 
                'description' => 'Permohonan telah ditambahkan data dukung.', 
                'status_button' => json_encode([
                    'color' => 'primary', 
                    'text' => 'Lanjutkan Isi RAB', 
                    'url' => 'permohonan.isi_rab', 
                    'permission' => 'view_rab'
                ]), 
                'action_buttons' => json_encode(
                    [
                    'color' => 'info', 
                    'icon' => 'bi bi-eye', 
                    'url' => 'permohonan.show', 
                    'permission' => 'check'
                    ],
                ),
            ],
            [
                'name' => 'draft', 
                'description' => 'Permohonan telah Didraft.', 
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
                            'icon' => 'bi bi-pencil-square', 
                            'url' => 'permohonan.edit', 
                            'permission' => 'edit'
                        ],
                        [
                            'color' => 'success', 
                            'icon' => 'bi bi-send', 
                            'url' => 'permohonan.send', 
                            'permission' => 'send'
                        ],
                    ]
                ),
            ],
            [
                'name' => 'dikirim', 
                'description' => 'Permohonan telah Dikirm.', 
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
                            'url' => 'permohonan.review', 
                            'permission' => 'review'
                        ],
                    ]
                ),
            ],
            [
                'name' => 'direview', 
                'description' => 'Permohonan telah Direview.', 
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
                            'icon' => 'bi bi-pencil-square', 
                            'url' => 'permohonan.review', 
                            'permission' => 'review'
                        ],
                        [
                            'color' => 'success', 
                            'icon' => 'bi bi-send', 
                            'url' => 'permohonan.send_review', 
                            'permission' => 'reviewed'
                        ],
                    ]
                ),
            ],
            [
                'name' => 'diteruskan', 
                'description' => 'Permohonan telah Diteruskan.', 
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
                            'url' => 'permohonan.confirm_review', 
                            'permission' => 'confirm_review'
                        ],
                    ]
                ),
            ],
            [
                'name' => 'direkomendasi', 
                'description' => 'Permohonan telah Direkomendasi.', 
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
                            'icon' => 'bi bi-pencil-square', 
                            'url' => 'permohonan.upload_rab', 
                            'permission' => 'upload_rab'
                        ],
                    ]
                ),
            ],
            [
                'name' => 'Koreksi', 
                'description' => 'Permohonan Harus Dikoreksi.', 
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
                            'icon' => 'bi bi-pencil-square', 
                            'url' => 'permohonan.revisi', 
                            'permission' => 'revisi'
                        ],
                        [
                            'color' => 'success', 
                            'icon' => 'bi bi-send', 
                            'url' => 'permohonan.send', 
                            'permission' => 'send'
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
                'name' => 'ditolak', 
                'description' => 'Permohonan Harus Ditolak.', 
                'status_button' => '', 
                'action_buttons' => json_encode(
                    [
                        [
                            'color' => 'info', 
                            'icon' => 'bi bi-eye', 
                            'url' => 'permohonan.show', 
                            'permission' => 'check'
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
        Schema::dropIfExists('status_permohonans');
    }
};
