<?php

// BRG-19 (brg-08) · spec docs/specs/brg-08.md §4 · tests 1–6

use App\Filament\Resources\Pages\Pages\EditPage;
use App\Models\Page;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

it('opens the page pages for both roles', function (string $role, string $page) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $path = match ($page) {
        'index' => '/admin/pages',
        'create' => '/admin/pages/create',
        'edit' => '/admin/pages/'.Page::factory()->create()->id.'/edit',
    };

    $this->actingAs($user)->get($path)->assertOk();
})->with(['admin', 'editor'])->with(['index', 'create', 'edit']);

it('lets an editor edit the title, body and seo fields', function () {
    $page = Page::factory()->create();

    Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
        ->fillForm([
            'title' => 'Política de privacidad',
            'body' => '<p>Texto nuevo.</p>',
            'seo_title' => 'Privacidad',
            'seo_description' => 'Cómo tratamos sus datos.',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $page->refresh();

    expect($page->getTranslations('title'))->toBe(['es' => 'Política de privacidad'])
        ->and($page->getTranslations('body'))->toBe(['es' => '<p>Texto nuevo.</p>'])
        ->and($page->getTranslations('seo_title'))->toBe(['es' => 'Privacidad'])
        ->and($page->getTranslations('seo_description'))->toBe(['es' => 'Cómo tratamos sus datos.']);
});

it('keeps the slug when a page is edited', function () {
    $page = Page::factory()->create(['slug' => ['es' => 'privacidad']]);

    Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
        ->fillForm(['slug' => 'otra-cosa'])
        ->call('save');

    expect($page->fresh()->getTranslation('slug', 'es'))->toBe('privacidad');
});

it('never deletes the privacy page', function (string $role) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $page = Page::factory()->create(['slug' => ['es' => 'privacidad']]);
    $this->actingAs($user);

    Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
        ->assertActionHidden(DeleteAction::class);

    expect(Gate::allows('delete', $page))->toBeFalse()
        ->and($page->exists())->toBeTrue();
})->with(['admin', 'editor']);

it('lets an editor delete another page', function () {
    $page = Page::factory()->create(['slug' => ['es' => 'nosotros']]);

    Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
        ->callAction(DeleteAction::class);

    expect(Page::count())->toBe(0);
});

it('loads the Spanish body into the edit form', function () {
    $page = Page::factory()->create([
        'title' => ['es' => 'Nosotros'],
        'body' => ['es' => '<p>Somos traductores.</p>'],
    ]);

    Livewire::test(EditPage::class, ['record' => $page->getRouteKey()])
        ->assertSchemaStateSet(['title' => 'Nosotros', 'body' => '<p>Somos traductores.</p>']);
});
