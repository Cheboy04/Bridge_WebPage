<?php

// BRG-13 (brg-02) · spec docs/specs/brg-02.md §4 · tests 6–7
// The expected values are the User and Settings rows of ADR D8.1.

use App\Models\Settings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;

uses(RefreshDatabase::class);

it('applies the permission matrix', function (string $role, string $ability, string $model, bool $expected) {
    $user = $role === 'admin' ? User::factory()->admin()->create() : User::factory()->create();
    $target = match (true) {
        in_array($ability, ['viewAny', 'create']) => $model,
        $model === Settings::class => Settings::current(),
        default => User::factory()->create(),
    };

    expect(Gate::forUser($user)->allows($ability, $target))->toBe($expected);
})->with([
    'admin views users' => ['admin', 'viewAny', User::class, true],
    'admin creates users' => ['admin', 'create', User::class, true],
    'admin updates users' => ['admin', 'update', User::class, true],
    'admin deletes users' => ['admin', 'delete', User::class, true],
    'editor views users' => ['editor', 'viewAny', User::class, false],
    'editor creates users' => ['editor', 'create', User::class, false],
    'editor updates users' => ['editor', 'update', User::class, false],
    'editor deletes users' => ['editor', 'delete', User::class, false],
    'admin views settings' => ['admin', 'view', Settings::class, true],
    'admin updates settings' => ['admin', 'update', Settings::class, true],
    'admin creates settings' => ['admin', 'create', Settings::class, false],
    'admin deletes settings' => ['admin', 'delete', Settings::class, false],
    'editor views settings' => ['editor', 'view', Settings::class, false],
    'editor updates settings' => ['editor', 'update', Settings::class, false],
]);

it('stops an admin from deleting their own account', function () {
    $admin = User::factory()->admin()->create();

    expect(Gate::forUser($admin)->allows('delete', $admin))->toBeFalse()
        ->and(Gate::forUser($admin)->allows('delete', User::factory()->create()))->toBeTrue();
});
