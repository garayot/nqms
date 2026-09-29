<?php

namespace App\Models;

use App\Enums\DocumentStatus;
use App\Models\Concerns\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormTemplate extends Model
{
    use HasEncryptedRouteKey;

    protected $fillable = [
        'document_type_id',
        'document_reference_code',
        'doc_title',
        'responsible',
        'revision_number',
        'effectivity_date',
        'document_location',
        'status',
        'downloadable_attachment_path',
    ];

    protected $casts = [
        'effectivity_date' => 'date',
        'status' => DocumentStatus::class,
    ];

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
}
