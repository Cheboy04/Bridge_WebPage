<?php

// BRG-45 (brg-35) · spec docs/specs/brg-35.md §4 · tests 8–11
// Lists from spec §3.2 (the ERD's columns minus id and timestamps).

use App\Models\Client;
use App\Models\Faq;
use App\Models\Language;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('declares the ERD fillable columns', function (string $model, array $fillable) {
    expect((new $model)->getFillable())->toEqualCanonicalizing($fillable);
})->with([
    'Service' => [Service::class, ['title', 'slug', 'mode', 'summary', 'body', 'icon', 'image', 'turnaround', 'featured', 'sort', 'published', 'seo_title', 'seo_description']],
    'Language' => [Language::class, ['code', 'name', 'featured', 'sort', 'published']],
    'Faq' => [Faq::class, ['question', 'answer', 'service_id', 'sort']],
    'Post' => [Post::class, ['title', 'slug', 'excerpt', 'body', 'cover', 'published_at', 'seo_title', 'seo_description']],
    'Client' => [Client::class, ['name', 'logo', 'url', 'sector', 'logo_permission', 'sort']],
    'Testimonial' => [Testimonial::class, ['quote', 'person', 'role', 'company', 'client_id', 'published']],
    'Page' => [Page::class, ['title', 'slug', 'body', 'seo_title', 'seo_description']],
]);

it('declares the ERD translatable columns', function (string $model, array $translatable) {
    expect((new $model)->getTranslatableAttributes())->toEqualCanonicalizing($translatable);
})->with([
    'Service' => [Service::class, ['title', 'slug', 'summary', 'body', 'turnaround', 'seo_title', 'seo_description']],
    'Language' => [Language::class, ['name']],
    'Faq' => [Faq::class, ['question', 'answer']],
    'Post' => [Post::class, ['title', 'slug', 'excerpt', 'body', 'seo_title', 'seo_description']],
    'Client' => [Client::class, ['sector']],
    'Testimonial' => [Testimonial::class, ['quote', 'role']],
    'Page' => [Page::class, ['title', 'slug', 'body', 'seo_title', 'seo_description']],
]);

it('stores translatable text per locale', function () {
    $service = Service::factory()->create(['title' => ['es' => 'Traducción certificada']]);

    expect($service->fresh()->getTranslation('title', 'es'))->toBe('Traducción certificada')
        ->and(json_decode(DB::table('services')->where('id', $service->id)->value('title'), true))
        ->toBe(['es' => 'Traducción certificada']);
});

it('rejects an unknown service mode', function () {
    expect(fn () => (new Service)->setAttribute('mode', 'otro'))->toThrow(ValueError::class);
});
