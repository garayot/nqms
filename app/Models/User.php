<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use App\Models\Concerns\HasEncryptedRouteKey;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'google_id', 'avatar', 'office', 'role'])]
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

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isApprover(): bool
    {
        return $this->role === UserRole::APPROVER;
    }

    public function isUser(): bool
    {
        return $this->role === UserRole::USER;
    }
}
