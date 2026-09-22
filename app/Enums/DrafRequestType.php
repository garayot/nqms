<?php

namespace App\Enums;

enum DrafRequestType: string
{
    case CREATION = 'creation';
    case REVISION = 'revision';
    case DISPOSITION = 'disposition';

    public function label(): string
    {
        return match ($this) {
            self::CREATION => 'Creation',
            self::REVISION => 'Revision',
            self::DISPOSITION => 'Disposition / Deletion',
        };
    }
}
