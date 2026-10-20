<?php

// BRG-13 (brg-02) · spec docs/specs/brg-02.md §4 · tests 8–11

use App\Enums\UserRole;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->admin()->create());
});

it('lets an admin create a user with a role', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Ana Prueba',
            'email' => 'ana@example.test',
            'password' => 'secreto-de-prueba',
            'role' => UserRole::Admin->value,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    expect(User::firstWhere('email', 'ana@example.test')->role)->toBe(UserRole::Admin);
});

it('lets an admin change a role', function () {
    $user = User::factory()->create();

    Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
        ->fillForm(['role' => UserRole::Admin->value])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->fresh()->role)->toBe(UserRole::Admin);
});

it('keeps the password when the edit leaves it blank', function () {
    $user = User::factory()->create();
    $hash = $user->password;

    Livewire::test(EditUser::class, ['record' => $user->getRouteKey()])
        ->fillForm(['name' => 'Nombre Nuevo', 'password' => ''])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($user->fresh())
        ->name->toBe('Nombre Nuevo')
        ->password->toBe($hash);
});

it('rejects a duplicate email', function () {
    User::factory()->create(['email' => 'repetido@example.test']);

    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Otra Persona',
            'email' => 'repetido@example.test',
            'password' => 'secreto-de-prueba',
            'role' => UserRole::Editor->value,
        ])
        ->call('create')
        ->assertHasFormErrors(['email' => 'unique']);
});
