<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhitelistedUser extends Model
{
    protected $table = 'whitelisted_users';

    protected $fillable = [
        'name',
        'email',
        'office',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSearch($query, string $term = null)
    {
        if (! filled($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('office', 'like', "%{$term}%");
        });
    }
}
