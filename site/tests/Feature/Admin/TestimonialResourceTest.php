<?php

// BRG-18 (brg-07) · spec docs/specs/brg-07.md §4 · tests 8–9

use App\Filament\Resources\Testimonials\Pages\CreateTestimonial;
use App\Models\Client;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('opens the testimonial pages for both roles', function (string $role, string $page) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $path = match ($page) {
        'index' => '/admin/testimonials',
        'create' => '/admin/testimonials/create',
        'edit' => '/admin/testimonials/'.Testimonial::factory()->create()->id.'/edit',
    };

    $this->actingAs($user)->get($path)->assertOk();
})->with(['admin', 'editor'])->with(['index', 'create', 'edit']);

it('creates an unpublished testimonial linked to a client', function () {
    $client = Client::factory()->create();

    Livewire::test(CreateTestimonial::class)
        ->fillForm(['quote' => 'Entregaron a tiempo.', 'person' => 'Ana Prueba', 'client_id' => $client->id])
        ->call('create')
        ->assertHasNoFormErrors();

    $testimonial = Testimonial::sole();

    expect($testimonial->getTranslations('quote'))->toBe(['es' => 'Entregaron a tiempo.'])
        ->and($testimonial->client_id)->toBe($client->id)
        ->and($testimonial->published)->toBeFalse();
});
