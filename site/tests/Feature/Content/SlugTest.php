<?php

// BRG-45 (brg-35) · spec docs/specs/brg-35.md §4 · tests 2–3
// ERD I3: public slugs are unique per locale through a functional index on slug.es.

use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('rejects a duplicate Spanish slug', function (string $model) {
    $model::factory()->create(['slug' => ['es' => 'repetido']]);

    expect(fn () => $model::factory()->create(['slug' => ['es' => 'repetido']]))
        ->toThrow(UniqueConstraintViolationException::class);
})->with([
    'services' => [Service::class],
    'posts' => [Post::class],
    'pages' => [Page::class],
]);

it('accepts the same slug under another locale', function () {
    Service::factory()->create(['slug' => ['es' => 'uno', 'en' => 'same']]);
    Service::factory()->create(['slug' => ['es' => 'dos', 'en' => 'same']]);

    expect(Service::count())->toBe(2);
});
