<?php

namespace App\Policies;

use App\Models\Settings;
use App\Models\User;

/** Admin only; no create or delete, the row is single (ADR D8.1, ERD I11). */
class SettingsPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Settings $settings): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Settings $settings): bool
    {
        return $user->isAdmin();
    }
}
