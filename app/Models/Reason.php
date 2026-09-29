<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reason extends Model
{
    protected $fillable = [
        'name',
    ];

    public function drafs(): HasMany
    {
        return $this->hasMany(Draf::class, 'reason_id');
    }
}
