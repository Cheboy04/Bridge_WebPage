<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Invented data only (ADR D2.2, D6.4).
 *
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'quote' => ['es' => fake()->sentence(12)],
            'person' => fake()->name(),
            'role' => ['es' => fake()->jobTitle()],
            'published' => true,
        ];
    }
}
