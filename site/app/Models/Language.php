<?php

namespace App\Models;

use Database\Factories\LanguageFactory;
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
}
