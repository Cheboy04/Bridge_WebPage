<?php

// BRG-42 (brg-32) · spec docs/specs/brg-32.md §4 · test 1
// Lessons: CI must run against the same engine as production, so the suite proves it isn't on SQLite.

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

uses(RefreshDatabase::class);

it('runs the suite against MySQL', function () {
    expect(DB::connection()->getDriverName())->toBe('mysql')
        ->and(Schema::hasTable('users'))->toBeTrue()
        ->and(Schema::hasTable('sessions'))->toBeTrue()
        ->and(Schema::hasTable('jobs'))->toBeTrue();
});
