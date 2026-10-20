<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

/**
 * @property Carbon|null $published_at
 */
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory, HasTranslations;

    /**
     * Columns from docs/erd/modelo-contenido.md, minus id and timestamps.
     *
     * @var list<string>
     */
    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'cover', 'published_at', 'seo_title', 'seo_description'];

    /** @var list<string> */
    public array $translatable = ['title', 'slug', 'excerpt', 'body', 'seo_title', 'seo_description'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['published_at' => 'datetime'];
    }

    /**
     * Public once `published_at` has passed; null is a draft (ERD §3.5).
     *
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    /**
     * Sanitised on save, on every write path (HU-06). Spatie runs this per
     * locale value. `Str::sanitizeHtml()` is Filament's configured Symfony
     * html-sanitizer.
     *
     * @return Attribute<never, string|null>
     */
    protected function body(): Attribute
    {
        return Attribute::set(fn (?string $value): ?string => $value === null ? null : Str::sanitizeHtml($value));
    }
}
