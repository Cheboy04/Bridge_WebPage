<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

/**
 * The one Settings row, empty: Bridge fills it in the admin (ERD I11, placeholder register).
 */
class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        Settings::current();
    }
}
