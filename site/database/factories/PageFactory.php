<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Invented data only (ADR D2.2, D6.4).
 *
 * @extends Factory<Page>
 */
class PageFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(2);

        return [
            'title' => ['es' => $title],
            'slug' => ['es' => Str::slug($title)],
            'body' => ['es' => fake()->paragraphs(2, true)],
        ];
    }
}
