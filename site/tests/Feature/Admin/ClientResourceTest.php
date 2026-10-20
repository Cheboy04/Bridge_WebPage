<?php

// BRG-18 (brg-07) · spec docs/specs/brg-07.md §4 · tests 1–6

use App\Filament\Resources\Clients\Pages\CreateClient;
use App\Filament\Resources\Clients\Pages\EditClient;
use App\Filament\Resources\Clients\Pages\ListClients;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('opens the client pages for both roles', function (string $role, string $page) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $path = match ($page) {
        'index' => '/admin/clients',
        'create' => '/admin/clients/create',
        'edit' => '/admin/clients/'.Client::factory()->create()->id.'/edit',
    };

    $this->actingAs($user)->get($path)->assertOk();
})->with(['admin', 'editor'])->with(['index', 'create', 'edit']);

it('creates a client without logo permission by default', function () {
    Livewire::test(CreateClient::class)
        ->fillForm(['name' => 'Notaría de Prueba'])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(Client::sole()->logo_permission)->toBeFalse();
});

it('says a written permission is required', function () {
    $this->get('/admin/clients/create')->assertSee(__('admin.clients.fields.logo_permission_help'));
});

it('records a granted permission', function () {
    $client = Client::factory()->create(['logo_permission' => false]);

    Livewire::test(EditClient::class, ['record' => $client->getRouteKey()])
        ->fillForm(['logo_permission' => true])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($client->fresh()->logo_permission)->toBeTrue();
});

it('reorders clients by drag', function () {
    [$a, $b, $c] = Client::factory()->count(3)->sequence(['sort' => 1], ['sort' => 2], ['sort' => 3])->create();

    Livewire::test(ListClients::class)->call('reorderTable', [$c->id, $a->id, $b->id]);

    expect(Client::orderBy('sort')->pluck('id')->all())->toBe([$c->id, $a->id, $b->id]);
});

it('loads the Spanish sector into the edit form', function () {
    $client = Client::factory()->create(['sector' => ['es' => 'Gobierno']]);

    Livewire::test(EditClient::class, ['record' => $client->getRouteKey()])
        ->assertSchemaStateSet(['sector' => 'Gobierno']);
});
