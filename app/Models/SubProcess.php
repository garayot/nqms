<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubProcess extends Model
{
    protected $fillable = [
        'sub_process_name',
        'url',
        'process_id',
    ];

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class);
    }
}
