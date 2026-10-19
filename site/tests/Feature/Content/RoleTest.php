<?php

// BRG-45 (brg-35) · spec docs/specs/brg-35.md §4 · tests 12–13
// ERD Q4 (default editor) and spec §3.5 (role is never mass-assigned).

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('gives new users the editor role', function () {
    expect(User::factory()->create()->fresh()->role)->toBe(UserRole::Editor);
});

it('does not mass-assign the role', function () {
    $user = User::create([
        'name' => 'Ana Prueba',
        'email' => 'ana@example.test',
        'password' => 'secreto-de-prueba',
        'role' => 'admin',
    ]);

    expect($user->fresh()->role)->toBe(UserRole::Editor);
});
