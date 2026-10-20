<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Content both roles fully manage (ADR D8.1). Strict authorization needs
 * each method Filament asks for, so a missing one throws, never allows.
 */
abstract class StaffContentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Model $model): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Model $model): bool
    {
        return true;
    }

    public function delete(User $user, Model $model): bool
    {
        return true;
    }

    public function reorder(User $user): bool
    {
        return true;
    }
}
