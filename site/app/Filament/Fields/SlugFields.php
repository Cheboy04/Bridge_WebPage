<?php

namespace App\Filament\Fields;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

/**
 * The title + slug pair of sluggable resources (spec brg-06 §1): the slug
 * is proposed from the title on create and is unique on `slug->es` like
 * the functional index (ERD I3).
 */
final class SlugFields
{
    /** Lowercase kebab: URL slugs and sprite ids. */
    public const KEBAB = '/^[a-z0-9]+(?:-[a-z0-9]+)*$/';

    /**
     * @param  string  $labels  Translation prefix holding `title` and `slug`, e.g. `admin.posts.fields`.
     * @return array{TextInput, TextInput}
     */
    public static function make(string $labels): array
    {
        return [
            TextInput::make('title')
                ->label(__("{$labels}.title"))
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Set $set, ?string $state, string $operation): void {
                    if ($operation === 'create') {
                        $set('slug', Str::slug((string) $state));
                    }
                }),
            TextInput::make('slug')
                ->label(__("{$labels}.slug"))
                ->required()
                ->maxLength(255)
                ->regex(self::KEBAB)
                ->unique(column: 'slug->es', ignoreRecord: true),
        ];
    }
}
