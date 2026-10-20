<?php

// BRG-14 (brg-03) · spec docs/specs/brg-03.md §4 · test 10
// BRG-15 (brg-04) · spec docs/specs/brg-04.md §4 · test 8
// BRG-16 (brg-05) · spec docs/specs/brg-05.md §4 · test 8

use App\Models\Faq;
use App\Models\Language;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('keeps unpublished services out of the published scope', function () {
    $published = Service::factory()->create(['published' => true]);
    Service::factory()->create(['published' => false]);

    expect(Service::published()->pluck('id')->all())->toBe([$published->id]);
});

it('keeps unpublished languages out of the published scope', function () {
    $published = Language::factory()->create(['published' => true]);
    Language::factory()->create(['published' => false]);

    expect(Language::published()->pluck('id')->all())->toBe([$published->id]);
});

it('keeps service faqs out of the global scope', function () {
    $global = Faq::factory()->create();
    Faq::factory()->forService(Service::factory()->create())->create();

    expect(Faq::withoutService()->pluck('id')->all())->toBe([$global->id]);
});
