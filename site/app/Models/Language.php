<?php

namespace App\Models;

use App\Enums\ServiceMode;
use Database\Factories\LanguageFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Language extends Model
{
    /** @use HasFactory<LanguageFactory> */
    use HasFactory, HasTranslations;

    /**
     * Columns from docs/erd/modelo-contenido.md, minus id and timestamps.
     *
     * @var list<string>
     */
    protected $fillable = ['code', 'name', 'featured', 'sort', 'published'];

    /** @var list<string> */
    public array $translatable = ['name'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['featured' => 'boolean', 'published' => 'boolean'];
    }

    /**
     * @return BelongsToMany<Service, $this>
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    /**
     * @param  Builder<self>  $query
     */
    #[Scope]
    protected function published(Builder $query): void
    {
        $query->where('published', true);
    }

    /**
     * The LangChecker data (brand/COMPONENT-CONTRACTS.md). Services are only
     * published Documento ones: the checker links to the translation quote.
     *
     * @return array{languages: list<array{code: string, name: string, services: list<string>, featured: bool}>}
     */
    public static function checkerPayload(): array
    {
        $languages = self::query()->published()
            ->with(['services' => fn ($query) => $query->published()->where('mode', ServiceMode::Documento)->orderBy('sort')->orderBy('id')])
            ->orderBy('sort')
            ->orderBy('id')
            ->get();

        return ['languages' => $languages->map(fn (self $language): array => [
            'code' => $language->code,
            'name' => $language->name,
            'services' => $language->services->map(fn (Service $service): string => $service->slug)->values()->all(),
            'featured' => $language->featured,
        ])->values()->all()];
    }
}
