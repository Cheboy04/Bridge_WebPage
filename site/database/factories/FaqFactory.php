<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Invented data only (ADR D2.2, D6.4).
 *
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => ['es' => fake()->sentence().'?'],
            'answer' => ['es' => fake()->paragraph()],
        ];
    }

    public function forService(Service $service): static
    {
        return $this->state(['service_id' => $service->id]);
    }
}
