<?php

// BRG-46 (brg-36) · spec docs/specs/brg-36.md §4 · tests 2–4, 13
// ERD I10: one settings row, guarded by the database.

use App\Models\Settings;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

it('rejects a second settings row', function () {
    DB::table('settings')->insert([]);

    expect(fn () => DB::table('settings')->insert([]))
        ->toThrow(UniqueConstraintViolationException::class);
});

it('rejects a singleton other than one', function () {
    expect(fn () => DB::table('settings')->insert(['singleton' => 0]))
        ->toThrow(QueryException::class);

    // The table itself works: only the bad value was refused, not a missing table.
    DB::table('settings')->insert([]);
    expect(DB::table('settings')->count())->toBe(1);
});

it('returns the same row from current', function () {
    $first = Settings::current();
    $second = Settings::current();

    expect($second->id)->toBe($first->id)
        ->and(Settings::count())->toBe(1);
});

it('declares the ERD translatable columns', function () {
    expect((new Settings)->getTranslatableAttributes())
        ->toEqualCanonicalizing(['whatsapp_default_message', 'office_hours', 'stats', 'ata_text', 'hero_hook']);
});
