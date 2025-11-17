<?php

namespace Database\Factories;

use App\Models\Permohonan;
use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Status_permohonan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermohonanFactory extends Factory
{
    protected $model = Permohonan::class;

    public function definition(): array
    {
        $tanggal_mohon = fake()->dateTimeBetween('-1 year', 'now');
        $tahun_apbd = $tanggal_mohon->format('Y');
        $uuid = fake()->uuid();
        $timestamp = now()->timestamp . rand(1000, 9999);
        
        return [
            'id_lembaga' => Lembaga::factory(),
            'no_mohon' => $this->generateNoMohon($tahun_apbd, $timestamp),
            'tanggal_mohon' => $tanggal_mohon,
            'tahun_apbd' => $tahun_apbd,
            'perihal_mohon' => 'Permohonan Hibah ' . fake()->words(3, true) . ' - ' . $uuid,
            'file_mohon' => 'permohonan/mohon_' . $uuid . '.pdf',
            'no_proposal' => $this->generateNoProposal($tahun_apbd, $timestamp),
            'tanggal_proposal' => fake()->dateTimeBetween($tanggal_mohon, 'now'),
            'title' => fake()->sentence(6) . ' [' . substr($uuid, 0, 8) . ']',
            'urusan' => UrusanSkpd::factory(),
            'id_skpd' => Skpd::factory(),
            'awal_laksana' => fake()->dateTimeBetween('now', '+1 month'),
            'akhir_laksana' => fake()->dateTimeBetween('+1 month', '+1 year'),
            'latar_belakang' => fake()->paragraph(5),
            'maksud_tujuan' => fake()->paragraph(3),
            'keterangan' => fake()->paragraph(2),
            'file_proposal' => 'proposals/proposal_' . $uuid . '.pdf',
            'nominal_rab' => fake()->numberBetween(10000000, 500000000),
            'nominal_anggaran' => fake()->numberBetween(10000000, 500000000),
            'id_status' => Status_permohonan::factory(),
            'status_rekomendasi' => null,
            'nominal_rekomendasi' => 0,
            'tanggal_rekomendasi' => null,
            'catatan_rekomendasi' => null,
            'file_pemberitahuan' => null,
            'file_permintaan_nphd' => null,
        ];
    }

    private function generateNoMohon($tahun, $timestamp = null): string
    {
        $urut = $timestamp ?? fake()->unique()->numberBetween(1, 999999);
        return sprintf('%06d/HIBAH/LEMBAGA/%s', $urut, $tahun);
    }

    private function generateNoProposal($tahun, $timestamp = null): string
    {
        $urut = $timestamp ?? fake()->unique()->numberBetween(1, 999999);
        return sprintf('%06d/PROPOSAL/%s', $urut, $tahun);
    }

    /**
     * Create permohonan with approved status
     */
    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status_rekomendasi' => 'disetujui',
                'nominal_rekomendasi' => $attributes['nominal_anggaran'] * 0.8, // 80% dari yang diminta
                'tanggal_rekomendasi' => fake()->dateTimeBetween($attributes['tanggal_mohon'], 'now'),
                'catatan_rekomendasi' => 'Disetujui dengan penyesuaian anggaran',
            ];
        });
    }

    /**
     * Create permohonan with rejected status
     */
    public function rejected(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status_rekomendasi' => 'ditolak',
                'nominal_rekomendasi' => 0,
                'tanggal_rekomendasi' => fake()->dateTimeBetween($attributes['tanggal_mohon'], 'now'),
                'catatan_rekomendasi' => 'Tidak sesuai dengan kriteria hibah yang ditetapkan',
            ];
        });
    }

    /**
     * Create permohonan in review process
     */
    public function inReview(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'status_rekomendasi' => 'dalam_review',
                'catatan_rekomendasi' => 'Sedang dalam proses review',
            ];
        });
    }
}