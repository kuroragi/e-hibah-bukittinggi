<?php

namespace Database\Factories;

use App\Models\KabKota;
use App\Models\Propinsi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KabKotaFactory extends Factory
{
    protected $model = KabKota::class;

    public function definition(): array
    {
        return [
            'id_propinsi' => Propinsi::factory(),
            'name' => 'Kota Bukittinggi',
        ];
    }
}