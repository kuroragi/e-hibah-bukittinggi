<?php

namespace Database\Factories;

use App\Models\Propinsi;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropinsiFactory extends Factory
{
    protected $model = Propinsi::class;

    public function definition(): array
    {
        $uuid = substr(fake()->uuid(), 0, 8);
        
        return [
            'name' => 'Sumatera Barat [' . $uuid . ']',
        ];
    }
}