<?php

// BRG-45 (brg-35) · spec docs/specs/brg-35.md §4 · tests 4–5

use App\Models\Language;
use App\Models\Service;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('rejects a duplicate language code', function () {
    Language::factory()->create(['code' => 'en']);

    expect(fn () => Language::factory()->create(['code' => 'en']))
        ->toThrow(UniqueConstraintViolationException::class);
});

it('rejects a duplicate language-service pair', function () {
    $service = Service::factory()->create();
    $language = Language::factory()->create();
    $service->languages()->attach($language);

    expect(fn () => $service->languages()->attach($language))
        ->toThrow(UniqueConstraintViolationException::class);
});
