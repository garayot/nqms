<?php

namespace App\Models;

use App\Models\Concerns\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasEncryptedRouteKey;

    protected $fillable = [
        'position_name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
