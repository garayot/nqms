<?php

namespace App\Enums;

enum ReviewDecision: string
{
    case RECOMMEND_APPROVAL = 'recommend_approval';
    case DISAPPROVED = 'disapproved';

    public function label(): string
    {
        return match ($this) {
            self::RECOMMEND_APPROVAL => 'Recommend Approval',
            self::DISAPPROVED => 'Disapproved',
        };
    }
}
