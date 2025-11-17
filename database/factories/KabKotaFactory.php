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
        $uuid = substr(fake()->uuid(), 0, 8);
        
        return [
            'id_propinsi' => Propinsi::factory(),
            'name' => 'Kota Bukittinggi [' . $uuid . ']',
        ];
    }
}