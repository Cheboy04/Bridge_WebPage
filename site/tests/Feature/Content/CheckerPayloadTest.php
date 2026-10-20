<?php

// BRG-15 (brg-04) · spec docs/specs/brg-04.md §4 · tests 9–10
// Shape: brand/COMPONENT-CONTRACTS.md, LangChecker.

use App\Models\Language;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('builds the checker data from published languages', function () {
    $certified = Service::factory()->documento()->create(['slug' => ['es' => 'certificada']]);
    Language::factory()->create(['code' => 'fr', 'name' => ['es' => 'Francés'], 'sort' => 2])->services()->attach($certified);
    Language::factory()->create(['code' => 'en', 'name' => ['es' => 'Inglés'], 'sort' => 1, 'featured' => true])->services()->attach($certified);
    Language::factory()->create(['code' => 'de', 'published' => false])->services()->attach($certified);

    expect(Language::checkerPayload())->toBe(['languages' => [
        ['code' => 'en', 'name' => 'Inglés', 'services' => ['certificada'], 'featured' => true],
        ['code' => 'fr', 'name' => 'Francés', 'services' => ['certificada'], 'featured' => false],
    ]]);
});

it('lists only published translation services', function () {
    $language = Language::factory()->create();
    $language->services()->attach([
        Service::factory()->documento()->create(['slug' => ['es' => 'legal']])->id,
        Service::factory()->documento()->create(['slug' => ['es' => 'oculto'], 'published' => false])->id,
        Service::factory()->cabina()->create(['slug' => ['es' => 'simultanea']])->id,
    ]);

    expect(Language::checkerPayload()['languages'][0]['services'])->toBe(['legal']);
});
