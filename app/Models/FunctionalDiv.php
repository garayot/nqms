<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FunctionalDiv extends Model
{
    protected $table = 'functional_div';

    protected $fillable = [
        'name',
        'url',
    ];

    public function planningDocs(): HasMany
    {
        return $this->hasMany(PlanningDoc::class);
    }
}
