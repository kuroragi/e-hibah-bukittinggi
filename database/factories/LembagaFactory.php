<?php

namespace Database\Factories;

use App\Models\Lembaga;
use App\Models\Skpd;
use App\Models\UrusanSkpd;
use App\Models\Kelurahan;
use Illuminate\Database\Eloquent\Factories\Factory;

class LembagaFactory extends Factory
{
    protected $model = Lembaga::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'acronym' => fake()->lexify('???'),
            'id_skpd' => Skpd::factory(),
            'id_urusan' => UrusanSkpd::factory(),
            'email' => fake()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'id_kelurahan' => Kelurahan::factory(),
            'alamat' => fake()->address(),
            'photo' => null,
            'npwp' => fake()->numerify('##.###.###.#-###.###'),
            'no_akta_kumham' => fake()->numerify('AHU-#######.AH.##.##'),
            'date_akta_kumham' => fake()->date(),
            'file_akta_kumham' => null,
            'no_domisili' => fake()->numerify('###/DOM/####'),
            'date_domisili' => fake()->date(),
            'file_domisili' => null,
            'no_operasional' => fake()->numerify('###/OP/####'),
            'date_operasional' => fake()->date(),
            'file_operasional' => null,
            'no_pernyataan' => fake()->numerify('###/SP/####'),
            'date_pernyataan' => fake()->date(),
            'file_pernyataan' => null,
            'id_bank' => fake()->numberBetween(1, 10),
            'atas_nama' => fake()->name(),
            'no_rekening' => fake()->bankAccountNumber(),
            'photo_rek' => null,
        ];
    }

    /**
     * Create lembaga with complete documentation
     */
    public function withDocuments(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'file_akta_kumham' => 'documents/akta_' . fake()->uuid() . '.pdf',
                'file_domisili' => 'documents/domisili_' . fake()->uuid() . '.pdf',
                'file_operasional' => 'documents/operasional_' . fake()->uuid() . '.pdf',
                'file_pernyataan' => 'documents/pernyataan_' . fake()->uuid() . '.pdf',
                'photo' => 'photos/lembaga_' . fake()->uuid() . '.jpg',
                'photo_rek' => 'photos/rekening_' . fake()->uuid() . '.jpg',
            ];
        });
    }
}