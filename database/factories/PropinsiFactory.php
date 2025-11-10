<?php

namespace Database\Factories;

use App\Models\Propinsi;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropinsiFactory extends Factory
{
    protected $model = Propinsi::class;

    public function definition(): array
    {
        return [
            'name' => 'Sumatera Barat',
        ];
    }
}