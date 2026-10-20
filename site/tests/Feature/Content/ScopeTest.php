<?php

// BRG-14 (brg-03) · spec docs/specs/brg-03.md §4 · test 10
// BRG-15 (brg-04) · spec docs/specs/brg-04.md §4 · test 8
// BRG-16 (brg-05) · spec docs/specs/brg-05.md §4 · test 8
// BRG-17 (brg-06) · spec docs/specs/brg-06.md §4 · test 4

use App\Models\Faq;
use App\Models\Language;
use App\Models\Post;
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

it('keeps drafts and scheduled posts out of the published scope', function () {
    $past = Post::factory()->create(['published_at' => now()->subDay()]);
    Post::factory()->draft()->create();
    $scheduled = Post::factory()->create(['published_at' => now()->addDay()]);

    expect(Post::published()->pluck('id')->all())->toBe([$past->id]);

    $this->travelTo(now()->addDays(2));

    expect(Post::published()->pluck('id')->sort()->values()->all())->toBe([$past->id, $scheduled->id]);
});
