<?php

// BRG-46 (brg-36) · spec docs/specs/brg-36.md §4 · test 1
// Columns come from docs/erd/modelo-leads-settings.md §3.

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('creates the lead and settings tables with the ERD columns', function (string $table, array $columns) {
    expect(Schema::hasTable($table))->toBeTrue()
        ->and(Schema::hasColumns($table, $columns))->toBeTrue();
})->with([
    'settings' => ['settings', ['id', 'singleton', 'phone_landline', 'phone_mobile', 'whatsapp_number', 'whatsapp_default_message', 'contact_email', 'notification_email', 'address', 'map_url', 'office_hours', 'socials', 'founding_year', 'stats', 'ata_text', 'hero_hook', 'legal_name', 'created_at', 'updated_at']],
    'leads' => ['leads', ['id', 'type', 'status', 'name', 'email', 'phone', 'company', 'message', 'service_id', 'source_language_id', 'target_language_id', 'needs', 'deadline', 'event_date', 'event_end_date', 'venue', 'modality', 'duration', 'days', 'language_count', 'attendees', 'consent_at', 'notes', 'created_at', 'updated_at']],
    'language_lead' => ['language_lead', ['language_id', 'lead_id']],
    'lead_attachments' => ['lead_attachments', ['id', 'lead_id', 'path', 'original_name', 'mime_type', 'size', 'created_at', 'updated_at']],
]);
