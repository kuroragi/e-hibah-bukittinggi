<?php

namespace Database\Factories;

use App\Models\Skpd;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkpdFactory extends Factory
{
    protected $model = Skpd::class;

    public function definition(): array
    {
        $skpdNames = [
            'Dinas Pendidikan',
            'Dinas Kesehatan',
            'Dinas Pekerjaan Umum',
            'Dinas Sosial',
            'Dinas Pemuda dan Olahraga',
            'Dinas Kebudayaan dan Pariwisata',
            'Dinas Lingkungan Hidup',
            'Badan Perencanaan Pembangunan Daerah',
            'Dinas Koperasi dan UKM',
            'Dinas Perindustrian dan Perdagangan'
        ];

        return [
            'name' => fake()->randomElement($skpdNames),
            'alamat' => fake()->address(),
            'deskripsi' => fake()->paragraph(2),
        ];
    }

    /**
     * Create SKPD with specific name
     */
    public function withName(string $name): static
    {
        return $this->state(function (array $attributes) use ($name) {
            return [
                'name' => $name,
            ];
        });
    }
}