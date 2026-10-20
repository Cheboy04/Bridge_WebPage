<?php

// BRG-13 (brg-02) · spec docs/specs/brg-02.md §4 · tests 1–5

use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

dataset('users pages', [
    'index' => fn () => '/admin/users',
    'create' => fn () => '/admin/users/create',
    'edit' => fn () => '/admin/users/'.User::factory()->create()->id.'/edit',
]);

it('redirects guests to the login', function (string $path) {
    $this->get($path)->assertRedirect('/admin/login');
})->with([
    'dashboard' => '/admin',
    'users index' => '/admin/users',
    'users create' => '/admin/users/create',
]);

it('lets both roles into the panel in production', function (string $role) {
    config(['app.env' => 'production']);
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();

    $this->actingAs($user)->get('/admin')->assertOk();
})->with(['admin', 'editor']);

it('forbids the users pages to editors', function (string $path) {
    $this->actingAs(User::factory()->create())->get($path)->assertForbidden();
})->with('users pages');

it('opens the users pages for admins', function (string $path) {
    $this->actingAs(User::factory()->admin()->create())->get($path)->assertOk();
})->with('users pages');

it('runs the panel in strict authorization mode', function () {
    expect(Filament::getPanel('admin')->isAuthorizationStrict())->toBeTrue();
});
