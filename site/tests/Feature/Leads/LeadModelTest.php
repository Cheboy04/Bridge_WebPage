<?php

// BRG-46 (brg-36) · spec docs/specs/brg-36.md §4 · tests 11–12, 14–17

use App\Enums\LeadNeed;
use App\Enums\LeadStatus;
use App\Models\Language;
use App\Models\Lead;
use App\Models\LeadAttachment;
use App\Models\Service;
use App\Models\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('starts new leads as new', function () {
    expect(Lead::factory()->create()->fresh()->status)->toBe(LeadStatus::New);
});

it('declares the ERD fillable columns', function (string $model, array $fillable) {
    expect((new $model)->getFillable())->toEqualCanonicalizing($fillable);
})->with([
    'Settings' => [Settings::class, ['phone_landline', 'phone_mobile', 'whatsapp_number', 'whatsapp_default_message', 'contact_email', 'notification_email', 'address', 'map_url', 'office_hours', 'socials', 'founding_year', 'stats', 'ata_text', 'hero_hook', 'legal_name']],
    'Lead' => [Lead::class, ['type', 'status', 'name', 'email', 'phone', 'company', 'message', 'service_id', 'source_language_id', 'target_language_id', 'needs', 'deadline', 'event_date', 'event_end_date', 'venue', 'modality', 'duration', 'days', 'language_count', 'attendees', 'consent_at', 'notes']],
    'LeadAttachment' => [LeadAttachment::class, ['path', 'original_name', 'mime_type', 'size']],
]);

it('casts needs to LeadNeed values', function () {
    $lead = Lead::factory()->create(['needs' => ['notarization', 'apostille']]);

    expect($lead->fresh()->needs->all())->toBe([LeadNeed::Notarization, LeadNeed::Apostille]);
});

it('rejects unknown enum values', function (string $column) {
    expect(fn () => (new Lead)->setAttribute($column, 'otro'))->toThrow(ValueError::class);
})->with([
    'type' => ['type'],
    'status' => ['status'],
    'modality' => ['modality'],
    'duration' => ['duration'],
]);

it('resolves every ERD relation', function (array $pair) {
    [$resolved, $expected] = $pair;

    expect($resolved)->not->toBeNull()
        ->and($resolved->is($expected))->toBeTrue();
})->with([
    'service' => function () {
        $service = Service::factory()->create();

        return [Lead::factory()->create(['service_id' => $service->id])->service, $service];
    },
    'sourceLanguage' => function () {
        [$source, $target] = Language::factory()->count(2)->create();
        $lead = Lead::factory()->create(['source_language_id' => $source->id, 'target_language_id' => $target->id]);

        return [$lead->sourceLanguage, $source];
    },
    'targetLanguage' => function () {
        [$source, $target] = Language::factory()->count(2)->create();
        $lead = Lead::factory()->create(['source_language_id' => $source->id, 'target_language_id' => $target->id]);

        return [$lead->targetLanguage, $target];
    },
    'languages' => function () {
        $lead = Lead::factory()->create();
        $language = Language::factory()->create();
        $lead->languages()->attach($language);

        return [$lead->languages()->first(), $language];
    },
    'attachments' => function () {
        $lead = Lead::factory()->create();
        $attachment = LeadAttachment::factory()->for($lead)->create();

        return [$lead->attachments()->first(), $attachment];
    },
    'attachment lead' => function () {
        $lead = Lead::factory()->create();

        return [LeadAttachment::factory()->for($lead)->create()->lead, $lead];
    },
]);

it('builds every model from its factory', function (Closure $build) {
    expect($build()->fresh())->not->toBeNull();
})->with([
    'Settings' => [fn () => Settings::factory()->create()],
    'Lead contact' => [fn () => Lead::factory()->create()],
    'Lead translation' => [fn () => Lead::factory()->translation()->create()],
    'Lead interpreting' => [fn () => Lead::factory()->interpreting()->create()],
    'LeadAttachment' => [fn () => LeadAttachment::factory()->create()],
]);
