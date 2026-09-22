<?php

namespace App\Policies;

use App\Enums\DrafStatus;
use App\Models\Draf;
use App\Models\User;

class DrafPolicy
{
    public function view(User $user, Draf $draf): bool
    {
        return $user->id === $draf->requested_by || $user->isAdmin() || $user->isApprover();
    }

    public function update(User $user, Draf $draf): bool
    {
        return $user->id === $draf->requested_by && in_array($draf->status?->value, [
            DrafStatus::DRAFT->value,
            DrafStatus::REVIEW_DISAPPROVED->value,
            DrafStatus::APPROVAL_DISAPPROVED->value,
        ], true);
    }

    public function submit(User $user, Draf $draf): bool
    {
        return $user->id === $draf->requested_by && $draf->status === DrafStatus::DRAFT;
    }
}
