<?php

namespace App\Models;

use App\Enums\QmsOrganizationRole;
use App\Models\Concerns\HasEncryptedRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QmsOrganizationMember extends Model
{
    use HasEncryptedRouteKey;

    protected $fillable = [
        'role',
        'user_id',
        'display_order',
    ];

    protected function casts(): array
    {
        return [
            'role' => QmsOrganizationRole::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
