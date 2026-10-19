<?php

namespace Database\Factories;

use App\Enums\ServiceMode;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Invented data only (ADR D2.2, D6.4).
 *
 * @extends Factory<Service>
 */
class ServiceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'title' => ['es' => $title],
            'slug' => ['es' => Str::slug($title)],
            'mode' => fake()->randomElement(ServiceMode::cases()),
            'summary' => ['es' => fake()->sentence()],
            'body' => ['es' => fake()->paragraph()],
            'published' => true,
        ];
    }

    public function documento(): static
    {
        return $this->state(['mode' => ServiceMode::Documento]);
    }

    public function cabina(): static
    {
        return $this->state(['mode' => ServiceMode::Cabina]);
    }
}
