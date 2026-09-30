<?php

namespace App\Models;

use App\Models\Concerns\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasEncryptedRouteKey;

    protected $fillable = [
        'team_name',
        'abbreviation',
    ];

    public function teamLeads(): HasMany
    {
        return $this->hasMany(TeamLead::class);
    }

    public function teamMembers(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function teamSecretariat(): HasMany
    {
        return $this->hasMany(TeamSecretariat::class);
    }

    public function roleLabel(string $role): string
    {
        return trim($this->abbreviation.' '.$role);
    }
}
