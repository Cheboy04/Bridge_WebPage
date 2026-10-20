<?php

// BRG-14 (brg-03) · spec docs/specs/brg-03.md §4 · test 10

use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('keeps unpublished services out of the published scope', function () {
    $published = Service::factory()->create(['published' => true]);
    Service::factory()->create(['published' => false]);

    expect(Service::published()->pluck('id')->all())->toBe([$published->id]);
});
