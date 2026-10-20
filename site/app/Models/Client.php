<?php

namespace App\Models;

use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory, HasTranslations;

    /**
     * Columns from docs/erd/modelo-contenido.md, minus id and timestamps.
     *
     * @var list<string>
     */
    protected $fillable = ['name', 'logo', 'url', 'sector', 'logo_permission', 'sort'];

    /** @var list<string> */
    public array $translatable = ['sector'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['logo_permission' => 'boolean'];
    }

    /**
     * @return HasMany<Testimonial, $this>
     */
    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    /**
     * The only query for public logos: written permission and a logo, in
     * the row's order (HU-07, D4.1, DIRECTION §10).
     *
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function publicLogos(Builder $query): void
    {
        $query->where('logo_permission', true)->whereNotNull('logo')->orderBy('sort')->orderBy('id');
    }
}
