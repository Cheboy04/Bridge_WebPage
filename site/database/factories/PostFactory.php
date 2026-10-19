<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Invented data only (ADR D2.2, D6.4).
 *
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'title' => ['es' => $title],
            'slug' => ['es' => Str::slug($title)],
            'excerpt' => ['es' => fake()->sentence()],
            'body' => ['es' => fake()->paragraphs(3, true)],
            'published_at' => fake()->dateTimeBetween('-1 year', '-1 day'),
        ];
    }

    public function draft(): static
    {
        return $this->state(['published_at' => null]);
    }
}
