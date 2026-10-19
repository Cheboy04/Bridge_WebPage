<?php

// BRG-45 (brg-35) · spec docs/specs/brg-35.md §4 · tests 6–7
// ERD Q3: a service's FAQs go with it (never silently global); testimonials only lose their client.

use App\Models\Client;
use App\Models\Faq;
use App\Models\Language;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it("deletes a service's FAQs and language links with it", function () {
    $service = Service::factory()->create();
    $language = Language::factory()->create();
    $service->languages()->attach($language);
    $serviceFaq = Faq::factory()->forService($service)->create();
    $globalFaq = Faq::factory()->create();

    $service->delete();

    expect(Faq::find($serviceFaq->id))->toBeNull()
        ->and(Faq::find($globalFaq->id))->not->toBeNull()
        ->and(DB::table('language_service')->where('service_id', $service->id)->count())->toBe(0)
        ->and(Language::find($language->id))->not->toBeNull();
});

it('unlinks testimonials when their client is deleted', function () {
    $client = Client::factory()->create();
    $testimonial = Testimonial::factory()->create(['client_id' => $client->id]);

    $client->delete();

    expect($testimonial->fresh())->not->toBeNull()
        ->and($testimonial->fresh()->client_id)->toBeNull();
});
