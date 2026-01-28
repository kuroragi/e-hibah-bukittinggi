<?php

namespace Database\Factories;

use App\Models\Status_permohonan;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusPermohonanFactory extends Factory
{
    protected $model = Status_permohonan::class;

    public function definition(): array
    {
        $statusList = [
            ['name' => 'Draft', 'description' => 'Permohonan masih dalam tahap draft'],
            ['name' => 'Diajukan', 'description' => 'Permohonan telah diajukan'],
            ['name' => 'Dalam Review', 'description' => 'Permohonan sedang dalam review'],
            ['name' => 'Butuh Perbaikan', 'description' => 'Permohonan memerlukan perbaikan'],
            ['name' => 'Disetujui', 'description' => 'Permohonan telah disetujui'],
            ['name' => 'Ditolak', 'description' => 'Permohonan ditolak'],
            ['name' => 'Selesai', 'description' => 'Permohonan telah selesai diproses'],
        ];

        $status = fake()->randomElement($statusList);
        $uuid = substr(fake()->uuid(), 0, 8);

        return [
            'name' => $status['name'] . ' [' . $uuid . ']',
            'description' => $status['description'],
        ];
    }

    /**
     * Create draft status
     */
    public function draft(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Draft',
                'description' => 'Permohonan masih dalam tahap draft',
            ];
        });
    }

    /**
     * Create approved status
     */
    public function approved(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Disetujui',
                'description' => 'Permohonan telah disetujui',
            ];
        });
    }

    /**
     * Create rejected status
     */
    public function rejected(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Ditolak',
                'description' => 'Permohonan ditolak',
            ];
        });
    }
}