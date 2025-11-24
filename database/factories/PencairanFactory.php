<?php

namespace Database\Factories;

use App\Models\Pencairan;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PencairanFactory extends Factory
{
    protected $model = Pencairan::class;

    public function definition(): array
    {
        $uuid = Str::uuid();
        
        return [
            'id_permohonan' => Permohonan::factory(),
            'tanggal_pencairan' => fake()->dateTimeBetween('-1 year', 'now'),
            'jumlah_pencairan' => fake()->numberBetween(10000000, 100000000),
            'tahap_pencairan' => fake()->numberBetween(1, 3),
            'status' => fake()->randomElement(['diajukan', 'diverifikasi', 'disetujui', 'ditolak', 'dicairkan']),
            'bukti' => 'pencairan/bukti/bukti_' . $uuid . '.pdf',
            'keterangan' => fake()->optional()->paragraph(),
            'file_lpj' => 'pencairan/lpj/lpj_' . $uuid . '.pdf',
            'file_realisasi' => 'pencairan/realisasi/realisasi_' . $uuid . '.pdf',
            'file_dokumentasi' => 'pencairan/dokumentasi/dokumentasi_' . $uuid . '.pdf',
            'file_kwitansi' => 'pencairan/kwitansi/kwitansi_' . $uuid . '.pdf',
            'verified_by' => null,
            'verified_at' => null,
            'catatan_verifikasi' => null,
            'approved_by' => null,
            'approved_at' => null,
            'catatan_approval' => null,
        ];
    }

    /**
     * Indicate that the pencairan is verified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'diverifikasi',
            'verified_by' => User::factory(),
            'verified_at' => now(),
            'catatan_verifikasi' => fake()->paragraph(),
        ]);
    }

    /**
     * Indicate that the pencairan is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'disetujui',
            'verified_by' => User::factory(),
            'verified_at' => now()->subDays(2),
            'catatan_verifikasi' => fake()->paragraph(),
            'approved_by' => User::factory(),
            'approved_at' => now(),
            'catatan_approval' => fake()->paragraph(),
        ]);
    }

    /**
     * Indicate that the pencairan is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'dicairkan',
            'verified_by' => User::factory(),
            'verified_at' => now()->subDays(5),
            'catatan_verifikasi' => fake()->paragraph(),
            'approved_by' => User::factory(),
            'approved_at' => now()->subDays(3),
            'catatan_approval' => fake()->paragraph(),
        ]);
    }

    /**
     * Indicate that the pencairan is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ditolak',
            'verified_by' => User::factory(),
            'verified_at' => now(),
            'catatan_verifikasi' => 'Dokumen tidak lengkap',
        ]);
    }
}
