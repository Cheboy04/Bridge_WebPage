<?php

// BRG-15 (brg-04) · spec docs/specs/brg-04.md §4 · tests 1–7

use App\Filament\Resources\Languages\Pages\CreateLanguage;
use App\Filament\Resources\Languages\Pages\EditLanguage;
use App\Filament\Resources\Languages\Pages\ListLanguages;
use App\Models\Language;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('opens the languages pages for both roles', function (string $role, string $page) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $path = match ($page) {
        'index' => '/admin/languages',
        'create' => '/admin/languages/create',
        'edit' => '/admin/languages/'.Language::factory()->create()->id.'/edit',
    };

    $this->actingAs($user)->get($path)->assertOk();
})->with(['admin', 'editor'])->with(['index', 'create', 'edit']);

it('lets an editor create a language with its services', function () {
    [$certified, $legal] = Service::factory()->documento()->count(2)->create();

    Livewire::test(CreateLanguage::class)
        ->fillForm(['code' => 'it', 'name' => 'Italiano', 'services' => [$certified->id, $legal->id]])
        ->call('create')
        ->assertHasNoFormErrors();

    $language = Language::sole();

    expect($language->getTranslations('name'))->toBe(['es' => 'Italiano'])
        ->and($language->services()->pluck('services.id')->sort()->values()->all())->toBe([$certified->id, $legal->id])
        ->and($language->published)->toBeFalse();
});

it('lets an editor change the services of a language', function () {
    [$old, $new] = Service::factory()->documento()->count(2)->create();
    $language = Language::factory()->create();
    $language->services()->attach($old);

    Livewire::test(EditLanguage::class, ['record' => $language->getRouteKey()])
        ->fillForm(['services' => [$new->id]])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($language->services()->pluck('services.id')->all())->toBe([$new->id]);
});

it('rejects a duplicate code', function () {
    Language::factory()->create(['code' => 'en']);

    Livewire::test(CreateLanguage::class)
        ->fillForm(['code' => 'en', 'name' => 'Inglés'])
        ->call('create')
        ->assertHasFormErrors(['code' => 'unique']);
});

it('rejects a code that is not an ISO 639 code', function (string $code) {
    Livewire::test(CreateLanguage::class)
        ->fillForm(['code' => $code, 'name' => 'Prueba'])
        ->call('create')
        ->assertHasFormErrors(['code' => 'regex']);
})->with(['EN', 'english', 'e', 'pt-br']);

it('reorders languages by drag', function () {
    [$a, $b, $c] = Language::factory()->count(3)->sequence(['sort' => 1], ['sort' => 2], ['sort' => 3])->create();

    Livewire::test(ListLanguages::class)->call('reorderTable', [$c->id, $a->id, $b->id]);

    expect(Language::orderBy('sort')->pluck('id')->all())->toBe([$c->id, $a->id, $b->id]);
});

it('lets an editor unpublish a language', function () {
    $language = Language::factory()->create(['published' => true]);

    Livewire::test(EditLanguage::class, ['record' => $language->getRouteKey()])
        ->fillForm(['published' => false])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($language->fresh()->published)->toBeFalse();
});
