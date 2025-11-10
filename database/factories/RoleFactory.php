<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        $roles = [
            ['name' => 'admin', 'guard_name' => 'web'],
            ['name' => 'skpd', 'guard_name' => 'web'],
            ['name' => 'lembaga', 'guard_name' => 'web'],
            ['name' => 'super-admin', 'guard_name' => 'web'],
        ];

        $role = fake()->randomElement($roles);

        return [
            'name' => $role['name'],
            'guard_name' => $role['guard_name'],
        ];
    }

    /**
     * Create admin role
     */
    public function admin(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'admin',
                'guard_name' => 'web',
            ];
        });
    }

    /**
     * Create skpd role
     */
    public function skpd(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'skpd',
                'guard_name' => 'web',
            ];
        });
    }

    /**
     * Create lembaga role
     */
    public function lembaga(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => 'lembaga',
                'guard_name' => 'web',
            ];
        });
    }
}