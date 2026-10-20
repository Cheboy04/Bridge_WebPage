<?php

// BRG-14 (brg-03) · spec docs/specs/brg-03.md §4 · tests 1–9

use App\Enums\ServiceMode;
use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

function serviceForm(array $overrides = []): array
{
    return array_merge([
        'title' => 'Traducción de prueba',
        'slug' => 'traduccion-de-prueba',
        'mode' => ServiceMode::Documento->value,
    ], $overrides);
}

it('opens the services pages for both roles', function (string $role, string $page) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $path = match ($page) {
        'index' => '/admin/services',
        'create' => '/admin/services/create',
        'edit' => '/admin/services/'.Service::factory()->create()->id.'/edit',
    };

    $this->actingAs($user)->get($path)->assertOk();
})->with(['admin', 'editor'])->with(['index', 'create', 'edit']);

it('lets an editor create a service', function () {
    Livewire::test(CreateService::class)
        ->fillForm(serviceForm(['mode' => ServiceMode::Cabina->value]))
        ->call('create')
        ->assertHasNoFormErrors();

    $service = Service::sole();

    expect($service->getTranslations('title'))->toBe(['es' => 'Traducción de prueba'])
        ->and($service->mode)->toBe(ServiceMode::Cabina)
        ->and($service->published)->toBeFalse();
});

it('loads the Spanish values into the edit form', function () {
    $service = Service::factory()->create(['title' => ['es' => 'Interpretación simultánea']]);

    Livewire::test(EditService::class, ['record' => $service->getRouteKey()])
        ->assertSchemaStateSet(['title' => 'Interpretación simultánea']);
});

it('requires a mode', function () {
    Livewire::test(CreateService::class)
        ->fillForm(serviceForm(['mode' => null]))
        ->call('create')
        ->assertHasFormErrors(['mode' => 'required']);
});

it('rejects a duplicate slug in either mode', function (ServiceMode $mode) {
    Service::factory()->documento()->create(['slug' => ['es' => 'repetido']]);

    Livewire::test(CreateService::class)
        ->fillForm(serviceForm(['slug' => 'repetido', 'mode' => $mode->value]))
        ->call('create')
        ->assertHasFormErrors(['slug' => 'unique']);

    expect(Service::count())->toBe(1);
})->with([
    'same mode' => ServiceMode::Documento,
    'other mode' => ServiceMode::Cabina,
]);

it('rejects a slug that is not lowercase kebab', function () {
    Livewire::test(CreateService::class)
        ->fillForm(serviceForm(['slug' => 'Con Espacios']))
        ->call('create')
        ->assertHasFormErrors(['slug' => 'regex']);
});

it('reorders services by drag', function () {
    [$a, $b, $c] = Service::factory()->count(3)->sequence(['sort' => 1], ['sort' => 2], ['sort' => 3])->create();

    Livewire::test(ListServices::class)->call('reorderTable', [$c->id, $a->id, $b->id]);

    expect(Service::orderBy('sort')->pluck('id')->all())->toBe([$c->id, $a->id, $b->id]);
});

it('lets an editor unpublish and publish a service', function () {
    $service = Service::factory()->create(['published' => true]);

    foreach ([false, true] as $published) {
        Livewire::test(EditService::class, ['record' => $service->getRouteKey()])
            ->fillForm(['published' => $published])
            ->call('save')
            ->assertHasNoFormErrors();

        expect($service->fresh()->published)->toBe($published);
    }
});

it('stores the image on the public disk', function () {
    Storage::fake('public');

    Livewire::test(CreateService::class)
        ->fillForm(serviceForm(['image' => UploadedFile::fake()->create('cabina.jpg', 20, 'image/jpeg')]))
        ->call('create')
        ->assertHasNoFormErrors();

    $path = Service::sole()->image;

    expect($path)->toStartWith('services/');
    Storage::disk('public')->assertExists($path);
});
