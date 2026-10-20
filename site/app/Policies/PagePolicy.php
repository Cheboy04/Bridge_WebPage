<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Both roles manage pages, but the privacy page is never deleted (ADR D8.1).
 */
class PagePolicy extends StaffContentPolicy
{
    /** @param  Page  $model */
    public function delete(User $user, Model $model): bool
    {
        return $model->getTranslation('slug', 'es') !== 'privacidad';
    }
}
