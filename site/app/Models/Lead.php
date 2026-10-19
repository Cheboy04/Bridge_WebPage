<?php

namespace App\Models;

use App\Enums\EventDuration;
use App\Enums\EventModality;
use App\Enums\LeadNeed;
use App\Enums\LeadStatus;
use App\Enums\LeadType;
use Database\Factories\LeadFactory;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    /** @use HasFactory<LeadFactory> */
    use HasFactory;

    /**
     * Columns from docs/erd/modelo-leads-settings.md, minus id and timestamps.
     * `status` and `notes` are fillable for the inbox (brg-36 spec §3.2).
     *
     * @var list<string>
     */
    protected $fillable = ['type', 'status', 'name', 'email', 'phone', 'company', 'message', 'service_id', 'source_language_id', 'target_language_id', 'needs', 'deadline', 'event_date', 'event_end_date', 'venue', 'modality', 'duration', 'days', 'language_count', 'attendees', 'consent_at', 'notes'];

    /**
     * @return array<string, mixed>
     */
    protected function casts(): array
    {
        return [
            'type' => LeadType::class,
            'status' => LeadStatus::class,
            'modality' => EventModality::class,
            'duration' => EventDuration::class,
            'needs' => AsEnumCollection::of(LeadNeed::class),
            'deadline' => 'date',
            'event_date' => 'date',
            'event_end_date' => 'date',
            'consent_at' => 'datetime',
            'days' => 'integer',
            'language_count' => 'integer',
            'attendees' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return BelongsTo<Language, $this>
     */
    public function sourceLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'source_language_id');
    }

    /**
     * @return BelongsTo<Language, $this>
     */
    public function targetLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'target_language_id');
    }

    /**
     * The interpreting form's "¿Cuáles idiomas?".
     *
     * @return BelongsToMany<Language, $this>
     */
    public function languages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class);
    }

    /**
     * @return HasMany<LeadAttachment, $this>
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(LeadAttachment::class);
    }
}
