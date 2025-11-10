<?php

namespace Database\Factories;

use App\Models\Kecamatan;
use App\Models\KabKota;
use Illuminate\Database\Eloquent\Factories\Factory;

class KecamatanFactory extends Factory
{
    protected $model = Kecamatan::class;

    public function definition(): array
    {
        $kecamatanNames = [
            'Aur Birugo Tigo Baleh',
            'Guguk Panjang',
            'Mandiangin Koto Selayan',
        ];

        return [
            'id_kabkota' => KabKota::factory(),
            'name' => fake()->randomElement($kecamatanNames),
        ];
    }
}