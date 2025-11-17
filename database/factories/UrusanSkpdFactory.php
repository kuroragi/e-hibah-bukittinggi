<?php

namespace Database\Factories;

use App\Models\UrusanSkpd;
use App\Models\Skpd;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrusanSkpdFactory extends Factory
{
    protected $model = UrusanSkpd::class;

    public function definition(): array
    {
        $urusan = [
            'Pendidikan',
            'Kesehatan',
            'Pekerjaan Umum dan Penataan Ruang',
            'Perumahan Rakyat dan Kawasan Permukiman',
            'Ketentraman, Ketertiban Umum, dan Perlindungan Masyarakat',
            'Sosial',
            'Tenaga Kerja',
            'Pemberdayaan Perempuan dan Perlindungan Anak',
            'Pangan',
            'Pertanahan',
            'Lingkungan Hidup',
            'Administrasi Kependudukan dan Pencatatan Sipil',
            'Pemberdayaan Masyarakat dan Desa',
            'Pengendalian Penduduk dan Keluarga Berencana',
            'Perhubungan',
            'Komunikasi dan Informatika',
            'Koperasi, Usaha Kecil, dan Menengah',
            'Penanaman Modal',
            'Kepemudaan dan Olahraga',
            'Statistik',
            'Persandian',
            'Kebudayaan',
            'Perpustakaan',
            'Kearsipan',
            'Kelautan dan Perikanan',
            'Pariwisata',
            'Pertanian',
            'Kehutanan',
            'Energi dan Sumber Daya Mineral',
            'Perdagangan',
            'Perindustrian',
            'Transmigrasi'
        ];

        $uuid = substr(fake()->uuid(), 0, 8);

        return [
            'id_skpd' => Skpd::factory(),
            'nama_urusan' => fake()->randomElement($urusan) . ' [' . $uuid . ']',
            'kepala_urusan' => fake()->name(),
            'kegiatan' => null, // JSON field, can be set via state
        ];
    }

    /**
     * Create urusan for specific SKPD
     */
    public function forSkpd($skpdId): static
    {
        return $this->state(function (array $attributes) use ($skpdId) {
            return [
                'id_skpd' => $skpdId,
            ];
        });
    }
}