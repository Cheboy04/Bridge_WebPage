<?php

// BRG-45 (brg-35) · spec docs/specs/brg-35.md §4 · test 14
// Relations from spec §3.4. Each closure returns [resolved, expected].

use App\Models\Client;
use App\Models\Faq;
use App\Models\Language;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('resolves every ERD relation', function (array $pair) {
    [$resolved, $expected] = $pair;

    expect($resolved)->not->toBeNull()
        ->and($resolved->is($expected))->toBeTrue();
})->with([
    'Service languages' => function () {
        $service = Service::factory()->create();
        $language = Language::factory()->create();
        $service->languages()->attach($language);

        return [$service->languages()->first(), $language];
    },
    'Language services' => function () {
        $service = Service::factory()->create();
        $language = Language::factory()->create();
        $language->services()->attach($service);

        return [$language->services()->first(), $service];
    },
    'Service faqs' => function () {
        $service = Service::factory()->create();
        $faq = Faq::factory()->forService($service)->create();

        return [$service->faqs()->first(), $faq];
    },
    'Faq service' => function () {
        $service = Service::factory()->create();
        $faq = Faq::factory()->forService($service)->create();

        return [$faq->service, $service];
    },
    'Client testimonials' => function () {
        $client = Client::factory()->create();
        $testimonial = Testimonial::factory()->create(['client_id' => $client->id]);

        return [$client->testimonials()->first(), $testimonial];
    },
    'Testimonial client' => function () {
        $client = Client::factory()->create();
        $testimonial = Testimonial::factory()->create(['client_id' => $client->id]);

        return [$testimonial->client, $client];
    },
]);
