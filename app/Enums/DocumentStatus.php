<?php

namespace App\Enums;

enum DocumentStatus: string
{
    case ACTIVE = 'active';
    case OBSOLETE = 'obsolete';

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::OBSOLETE => 'Obsolete',
        };
    }
}
