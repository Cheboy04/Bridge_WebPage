<?php

// BRG-17 (brg-06) · spec docs/specs/brg-06.md §4 · tests 1–3, 7–8

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->create());
});

function postForm(array $overrides = []): array
{
    return array_merge([
        'title' => 'Apostilla paso a paso',
        'slug' => 'apostilla-paso-a-paso',
        'body' => '<p>Contenido de prueba.</p>',
    ], $overrides);
}

it('opens the post pages for both roles', function (string $role, string $page) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $path = match ($page) {
        'index' => '/admin/posts',
        'create' => '/admin/posts/create',
        'edit' => '/admin/posts/'.Post::factory()->create()->id.'/edit',
    };

    $this->actingAs($user)->get($path)->assertOk();
})->with(['admin', 'editor'])->with(['index', 'create', 'edit']);

it('saves a post without a date as a draft', function () {
    Livewire::test(CreatePost::class)
        ->fillForm(postForm())
        ->call('create')
        ->assertHasNoFormErrors();

    $post = Post::sole();

    expect($post->published_at)->toBeNull()
        ->and($post->getTranslations('title'))->toBe(['es' => 'Apostilla paso a paso']);
});

it('schedules a post for a future date', function () {
    Livewire::test(CreatePost::class)
        ->fillForm(postForm(['published_at' => '2030-01-15 09:00:00']))
        ->call('create')
        ->assertHasNoFormErrors();

    // Entered in America/Guayaquil (UTC-5), stored in UTC (ADR D3.2).
    expect(Post::sole()->published_at->utc()->format('Y-m-d H:i'))->toBe('2030-01-15 14:00');
});

it('rejects a duplicate slug', function () {
    Post::factory()->create(['slug' => ['es' => 'repetido']]);

    Livewire::test(CreatePost::class)
        ->fillForm(postForm(['slug' => 'repetido']))
        ->call('create')
        ->assertHasFormErrors(['slug' => 'unique']);
});

it('loads the Spanish title into the edit form', function () {
    $post = Post::factory()->create(['title' => ['es' => 'Traducir un acta']]);

    Livewire::test(EditPost::class, ['record' => $post->getRouteKey()])
        ->assertSchemaStateSet(['title' => 'Traducir un acta']);
});
