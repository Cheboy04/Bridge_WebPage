<?php

namespace App\Models;

use Database\Factories\LeadAttachmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAttachment extends Model
{
    /** @use HasFactory<LeadAttachmentFactory> */
    use HasFactory;

    /**
     * Columns from docs/erd/modelo-leads-settings.md, minus id, lead_id and timestamps.
     * `path` is on the private disk (ADR D7.1).
     *
     * @var list<string>
     */
    protected $fillable = ['path', 'original_name', 'mime_type', 'size'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return ['size' => 'integer'];
    }

    /**
     * @return BelongsTo<Lead, $this>
     */
    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }
}
