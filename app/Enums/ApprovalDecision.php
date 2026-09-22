<?php

namespace App\Enums;

enum ApprovalDecision: string
{
    case APPROVED = 'approved';
    case DISAPPROVED = 'disapproved';

    public function label(): string
    {
        return match ($this) {
            self::APPROVED => 'Approved',
            self::DISAPPROVED => 'Disapproved',
        };
    }
}
