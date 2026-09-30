<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanningDoc extends Model
{
    protected $fillable = [
        'name',
        'url',
        'functional_div_id',
    ];

    public function functionalDiv(): BelongsTo
    {
        return $this->belongsTo(FunctionalDiv::class);
    }
}
