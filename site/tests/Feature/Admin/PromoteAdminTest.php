<?php

// BRG-13 (brg-02) · spec docs/specs/brg-02.md §4 · tests 13–14

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('promotes an existing user to admin', function () {
    $user = User::factory()->create();

    $this->artisan('app:promote-admin', ['email' => $user->email])->assertSuccessful();

    expect($user->fresh()->role)->toBe(UserRole::Admin);
});

it('fails on an unknown email', function () {
    $user = User::factory()->create();

    $this->artisan('app:promote-admin', ['email' => 'nadie@example.test'])->assertFailed();

    expect($user->fresh()->role)->toBe(UserRole::Editor);
});
