<?php

namespace Database\Factories;

use App\Models\Kelurahan;
use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Factories\Factory;

class KelurahanFactory extends Factory
{
    protected $model = Kelurahan::class;

    public function definition(): array
    {
        $kelurahanNames = [
            'Aur Birugo Tigo Baleh',
            'Aur Kuning',
            'Birugo',
            'Bukik Cangang Kayu Ramang',
            'Campago Guguk Bulek',
            'Campago Ipuh',
            'Garegeh',
            'Guguk Malintang',
            'Gulai Bancah',
            'Ihsan',
            'Kayu Kubu',
            'Kubu Gulai Bancah',
            'Manggis Ganting',
            'Pakan Labuah',
            'Puhun Tembok',
            'Tarok Dipo',
        ];

        return [
            'id_kecamatan' => Kecamatan::factory(),
            'name' => fake()->randomElement($kelurahanNames),
        ];
    }
}