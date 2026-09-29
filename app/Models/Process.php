<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Process extends Model
{
    protected $fillable = [
        'process_name',
        'process_group_id',
    ];

    public function processGroup(): BelongsTo
    {
        return $this->belongsTo(ProcessGroup::class);
    }

    public function subProcesses(): HasMany
    {
        return $this->hasMany(SubProcess::class);
    }
}
