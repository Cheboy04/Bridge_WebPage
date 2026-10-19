<?php

namespace App\Models;

use Database\Factories\SettingsFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Settings extends Model
{
    /** @use HasFactory<SettingsFactory> */
    use HasFactory, HasTranslations;

    /**
     * Columns from docs/erd/modelo-leads-settings.md, minus id, singleton and timestamps.
     * `singleton` is left to its default: it is the single-row guard (ERD I10).
     *
     * @var list<string>
     */
    protected $fillable = ['phone_landline', 'phone_mobile', 'whatsapp_number', 'whatsapp_default_message', 'contact_email', 'notification_email', 'address', 'map_url', 'office_hours', 'socials', 'founding_year', 'stats', 'ata_text', 'hero_hook', 'legal_name'];

    /** @var list<string> */
    public array $translatable = ['whatsapp_default_message', 'office_hours', 'stats', 'ata_text', 'hero_hook'];

    /**
     * The single settings row, created empty on first use (brg-36 spec §3.5).
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['socials' => 'array', 'founding_year' => 'integer'];
    }
}
