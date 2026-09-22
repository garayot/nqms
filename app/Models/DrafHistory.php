<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrafHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'draf_id',
        'user_id',
        'action',
        'old_status',
        'new_status',
        'remarks',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function draf(): BelongsTo
    {
        return $this->belongsTo(Draf::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
