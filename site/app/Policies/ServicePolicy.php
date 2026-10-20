<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;

/** Both roles, every action (ADR D8.1). Strict mode needs each method. */
class ServicePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Service $service): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Service $service): bool
    {
        return true;
    }

    public function delete(User $user, Service $service): bool
    {
        return true;
    }

    public function reorder(User $user): bool
    {
        return true;
    }
}
