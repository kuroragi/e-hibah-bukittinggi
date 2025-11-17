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
        $uuid = fake()->uuid();
        return [
            'name' => fake()->company() . ' ' . $uuid, // Make name unique
            'acronym' => strtoupper(fake()->lexify('???')),
            'id_skpd' => Skpd::factory(),
            'id_urusan' => UrusanSkpd::factory(),
            'email' => fake()->unique()->safeEmail(), // Ensure unique email
            'phone' => fake()->unique()->numerify('62##########'), // 12 digits, unique
            'id_kelurahan' => Kelurahan::factory(),
            'alamat' => fake()->address(),
            'photo' => 'photos/lembaga_' . $uuid . '.jpg', // Required field
            'npwp' => fake()->unique()->numerify('##############'), // 14 digits, unique
            'no_akta_kumham' => 'AHU-' . fake()->unique()->numerify('#######') . '.AH.' . date('y') . '.01',
            'date_akta_kumham' => fake()->dateTimeBetween('-5 years', '-1 year'),
            'file_akta_kumham' => 'documents/akta_' . $uuid . '.pdf',
            'no_domisili' => fake()->unique()->numerify('###') . '/DOM/' . date('Y'),
            'date_domisili' => fake()->dateTimeBetween('-3 years', '-6 months'),
            'file_domisili' => 'documents/domisili_' . $uuid . '.pdf',
            'no_operasional' => fake()->unique()->numerify('###') . '/OP/' . date('Y'),
            'date_operasional' => fake()->dateTimeBetween('-2 years', '-3 months'),
            'file_operasional' => 'documents/operasional_' . $uuid . '.pdf',
            'no_pernyataan' => fake()->unique()->numerify('###') . '/SP/' . date('Y'),
            'date_pernyataan' => fake()->dateTimeBetween('-1 year', 'now'),
            'file_pernyataan' => 'documents/pernyataan_' . $uuid . '.pdf',
            'id_bank' => fake()->numberBetween(1, 10),
            'atas_nama' => fake()->name(),
            'no_rekening' => fake()->unique()->numerify('##########'),
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