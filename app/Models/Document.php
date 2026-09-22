<?php

namespace App\Models;

use App\Enums\DocumentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'draf_id',
        'originating_office_id',
        'location',
        'status',
        'downloadable_doc_path',
    ];

    protected $casts = [
        'status' => DocumentStatus::class,
    ];

    public function draf(): BelongsTo
    {
        return $this->belongsTo(Draf::class);
    }

    public function originatingOffice(): BelongsTo
    {
        return $this->belongsTo(User::class, 'originating_office_id');
    }
}
