<?php

// BRG-13 (brg-02) · spec docs/specs/brg-02.md §4 · test 12
// Guard rail: the limit is Filament's own (5 per minute). It fails if a
// custom login page drops it.

use App\Models\User;
use Filament\Auth\Pages\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('rate limits login attempts', function () {
    $user = User::factory()->create(['password' => 'secreto-de-prueba']);

    foreach (range(1, 5) as $attempt) {
        Livewire::test(Login::class)
            ->fillForm(['email' => $user->email, 'password' => 'incorrecta'])
            ->call('authenticate');
    }

    Livewire::test(Login::class)
        ->fillForm(['email' => $user->email, 'password' => 'secreto-de-prueba'])
        ->call('authenticate');

    $this->assertGuest();
});
