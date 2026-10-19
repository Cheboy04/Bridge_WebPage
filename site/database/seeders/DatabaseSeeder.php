<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database (brg-37 spec §1). Services before
     * languages: the language links look services up by slug.
     */
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            LanguageSeeder::class,
            SettingsSeeder::class,
            DemoContentSeeder::class,
        ]);
    }
}
