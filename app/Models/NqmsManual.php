<?php

namespace App\Models;

use App\Enums\DocumentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NqmsManual extends Model
{
    protected $fillable = [
        'document_type_id',
        'document_reference_code',
        'doc_title',
        'responsible',
        'created_by',
        'revision_number',
        'effectivity_date',
        'document_location',
        'status',
        'downloadable_attachment_url',
    ];

    protected $casts = [
        'effectivity_date' => 'date',
        'status' => DocumentStatus::class,
    ];

    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
