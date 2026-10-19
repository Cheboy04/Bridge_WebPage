<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Invented data only (ADR D2.2, D6.4).
 *
 * @extends Factory<Language>
 */
class LanguageFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->languageCode(),
            'name' => ['es' => ucfirst(fake()->word())],
            'published' => true,
        ];
    }
}
