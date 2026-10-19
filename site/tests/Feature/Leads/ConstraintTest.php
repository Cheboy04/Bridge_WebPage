<?php

// BRG-46 (brg-36) · spec docs/specs/brg-36.md §4 · tests 5–10
// ERD I13 (catalogue rows a lead references can't be deleted), I14 (contact channel, consent), I15.

use App\Models\Language;
use App\Models\Lead;
use App\Models\LeadAttachment;
use App\Models\Service;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('rejects a lead with no email or phone', function () {
    expect(fn () => Lead::factory()->create(['email' => null, 'phone' => null]))
        ->toThrow(QueryException::class);
});

it('accepts a lead with only a phone', function () {
    Lead::factory()->create(['email' => null, 'phone' => '+593 99 000 0000']);

    expect(Lead::count())->toBe(1);
});

it('rejects a lead without consent', function () {
    expect(fn () => Lead::factory()->create(['consent_at' => null]))
        ->toThrow(QueryException::class);
});

it('keeps a service that a lead references', function () {
    $service = Service::factory()->create();
    $lead = Lead::factory()->create(['service_id' => $service->id]);

    expect(fn () => $service->delete())->toThrow(QueryException::class)
        ->and(Service::find($service->id))->not->toBeNull()
        ->and($lead->fresh()->service_id)->toBe($service->id);
});

it('keeps a language that a lead references', function (string $role) {
    $language = Language::factory()->create();
    $lead = Lead::factory()->create(match ($role) {
        'source' => ['source_language_id' => $language->id],
        'target' => ['target_language_id' => $language->id],
        default => [],
    });
    if ($role === 'interpreting') {
        $lead->languages()->attach($language);
    }

    expect(fn () => $language->delete())->toThrow(QueryException::class)
        ->and(Language::find($language->id))->not->toBeNull();
})->with([
    'source' => ['source'],
    'target' => ['target'],
    'interpreting' => ['interpreting'],
]);

it('deletes attachment rows and language links with the lead', function () {
    $lead = Lead::factory()->create();
    $language = Language::factory()->create();
    $lead->languages()->attach($language);
    LeadAttachment::factory()->for($lead)->create();

    $lead->delete();

    expect(LeadAttachment::count())->toBe(0)
        ->and(DB::table('language_lead')->count())->toBe(0)
        ->and(Language::find($language->id))->not->toBeNull();
});
