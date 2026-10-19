<?php

namespace Database\Factories;

use App\Models\Lead;
use App\Models\LeadAttachment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Rows only: no file is written to the private disk (that's P5).
 *
 * @extends Factory<LeadAttachment>
 */
class LeadAttachmentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lead_id' => Lead::factory(),
            'path' => 'leads/'.fake()->uuid().'.pdf',
            'original_name' => 'documento.pdf',
            'mime_type' => 'application/pdf',
            'size' => fake()->numberBetween(10_000, 2_000_000),
        ];
    }
}
