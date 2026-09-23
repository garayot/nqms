<?php

namespace App\Models;

use App\Enums\ApprovalDecision;
use App\Enums\DrafApplicability;
use App\Enums\DrafRequestType;
use App\Enums\DrafSource;
use App\Enums\DrafStatus;
use App\Enums\ReviewDecision;
use App\Models\Concerns\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Draf extends Model
{
    use HasEncryptedRouteKey;

    protected $fillable = [
        'draf_number',
        'source',
        'request_for',
        'doc_type_id',
        'applicability',
        'title',
        'reference_code',
        'current_revision_no',
        'reason',
        'requested_by',
        'date_requested',
        'attachment_path',
        'status',
        'review',
        'reason1',
        'reviewed_by',
        'reviewed_at',
        'approval',
        'reason2',
        'approved_by',
        'approved_at',
        'new_revision_number',
        'effectivity_date',
        'date_registered',
        'approved_attachment_path',
    ];

    protected $casts = [
        'source' => DrafSource::class,
        'request_for' => DrafRequestType::class,
        'applicability' => DrafApplicability::class,
        'status' => DrafStatus::class,
        'review' => ReviewDecision::class,
        'approval' => ApprovalDecision::class,
        'date_requested' => 'date',
        'reviewed_at' => 'datetime',
        'approved_at' => 'datetime',
        'effectivity_date' => 'date',
        'date_registered' => 'date',
    ];

    public function requestedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class, 'doc_type_id');
    }

    public function document(): HasOne
    {
        return $this->hasOne(Document::class);
    }

    public function histories()
    {
        return $this->hasMany(DrafHistory::class);
    }

    public function scopeSearch($query, ?string $term = null)
    {
        if (! filled($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('draf_number', 'like', "%{$term}%")
                ->orWhere('title', 'like', "%{$term}%")
                ->orWhere('reference_code', 'like', "%{$term}%");
        });
    }

    public function isEditable(): bool
    {
        return in_array($this->status?->value, [
            DrafStatus::DRAFT->value,
            DrafStatus::REVIEW_DISAPPROVED->value,
            DrafStatus::APPROVAL_DISAPPROVED->value,
        ], true);
    }
}
