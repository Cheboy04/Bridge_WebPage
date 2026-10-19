<?php

// BRG-45 (brg-35) · spec docs/specs/brg-35.md §4 · test 15
// Factories hold invented data only (D2.2, D6.4).

use App\Models\Client;
use App\Models\Faq;
use App\Models\Language;
use App\Models\Page;
use App\Models\Post;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('builds every content model from its factory', function (string $model) {
    $record = $model::factory()->create()->fresh();

    expect($record)->not->toBeNull();
    foreach ($record->getTranslatableAttributes() as $attribute) {
        $translations = $record->getTranslations($attribute);
        if ($translations !== []) {
            expect($translations)->toHaveKey('es');
        }
    }
})->with([
    'Service' => [Service::class],
    'Language' => [Language::class],
    'Faq' => [Faq::class],
    'Post' => [Post::class],
    'Client' => [Client::class],
    'Testimonial' => [Testimonial::class],
    'Page' => [Page::class],
]);
