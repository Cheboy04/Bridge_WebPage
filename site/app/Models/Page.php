<?php

namespace App\Models;

use Database\Factories\PageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    /** @use HasFactory<PageFactory> */
    use HasFactory, HasTranslations;

    /**
     * Columns from docs/erd/modelo-contenido.md, minus id and timestamps.
     *
     * @var list<string>
     */
    protected $fillable = ['title', 'slug', 'body', 'seo_title', 'seo_description'];

    /** @var list<string> */
    public array $translatable = ['title', 'slug', 'body', 'seo_title', 'seo_description'];
}
