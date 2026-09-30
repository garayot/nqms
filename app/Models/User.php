<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Models\Concerns\HasEncryptedRouteKey;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'google_id', 'avatar', 'office', 'role', 'position_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasEncryptedRouteKey;

    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'avatar',
        'office',
        'role',
        'position_id',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }

    public function requestedDrafs(): HasMany
    {
        return $this->hasMany(Draf::class, 'requested_by');
    }

    public function reviewedDrafs(): HasMany
    {
        return $this->hasMany(Draf::class, 'reviewed_by');
    }

    public function approvedDrafs(): HasMany
    {
        return $this->hasMany(Draf::class, 'approved_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'originating_office_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function teamLeads(): HasMany
    {
        return $this->hasMany(TeamLead::class);
    }

    public function teamMemberships(): HasMany
    {
        return $this->hasMany(TeamMember::class);
    }

    public function teamSecretariats(): HasMany
    {
        return $this->hasMany(TeamSecretariat::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isApprover(): bool
    {
        return $this->role === UserRole::APPROVER;
    }

    public function isReviewer(): bool
    {
        return $this->role === UserRole::REVIEWER;
    }

    public function isUser(): bool
    {
        return $this->role === UserRole::USER;
    }
}
