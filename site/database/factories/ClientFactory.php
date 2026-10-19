<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Invented data only (ADR D2.2, D6.4).
 *
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'sector' => ['es' => ucfirst(fake()->word())],
            'logo_permission' => false,
        ];
    }
}
