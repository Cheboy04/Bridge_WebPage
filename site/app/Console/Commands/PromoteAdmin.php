<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;

/** Gives the owner the first admin on a server (spec brg-02 §3.5). */
class PromoteAdmin extends Command
{
    protected $signature = 'app:promote-admin {email}';

    protected $description = 'Give an existing user the admin role';

    public function handle(): int
    {
        $user = User::firstWhere('email', $this->argument('email'));

        if ($user === null) {
            $this->error('No user has that email.');

            return self::FAILURE;
        }

        $user->forceFill(['role' => UserRole::Admin])->save();
        $this->info("{$user->email} is now an admin.");

        return self::SUCCESS;
    }
}
