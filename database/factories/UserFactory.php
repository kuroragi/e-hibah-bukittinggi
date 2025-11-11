<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'id_role' => 3,
            'id_skpd' => null,
            'id_urusan' => null,
            'id_lembaga' => null,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Create user with admin role
     */
    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'id_role' => '1',
            ];
        });
    }

    /**
     * Create user with lembaga role
     */
    public function lembaga(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'Lembaga User',
                'email' => 'lembaga@example.com',
                'id_lembaga' => \App\Models\Lembaga::factory(),
                'id_skpd' => \App\Models\Skpd::factory(),
                'id_urusan' => \App\Models\UrusanSkpd::factory(),
            ];
        });
    }

    /**
     * Create user with skpd role
     */
    public function skpd(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'SKPD User',
                'email' => 'skpd@example.com',
                'id_skpd' => \App\Models\Skpd::factory(),
            ];
        });
    }
}
