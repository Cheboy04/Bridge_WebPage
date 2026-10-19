<?php

namespace Database\Factories;

use App\Enums\EventDuration;
use App\Enums\EventModality;
use App\Enums\LeadNeed;
use App\Enums\LeadType;
use App\Models\Language;
use App\Models\Lead;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Invented data only (ADR D2.2, D6.4).
 *
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => LeadType::Contact,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'message' => fake()->sentence(),
            'consent_at' => now(),
        ];
    }

    public function translation(): static
    {
        return $this->state(fn () => [
            'type' => LeadType::Translation,
            'service_id' => Service::factory()->documento(),
            'source_language_id' => Language::factory(),
            'target_language_id' => Language::factory(),
            'needs' => [LeadNeed::TranslatorCertification, LeadNeed::Apostille],
            'deadline' => now()->addWeeks(2)->toDateString(),
        ]);
    }

    public function interpreting(): static
    {
        return $this->state(fn () => [
            'type' => LeadType::Interpreting,
            'service_id' => Service::factory()->cabina(),
            'event_date' => now()->addMonths(2)->toDateString(),
            'venue' => 'Quito',
            'modality' => EventModality::InPerson,
            'duration' => EventDuration::FullDay,
            'language_count' => 1,
            'attendees' => 120,
            'needs' => [LeadNeed::Booths, LeadNeed::Receivers],
        ]);
    }
}
