<?php

namespace App\Enums;

enum DrafApplicability: string
{
    case CO = 'co';
    case RO = 'ro';
    case SDO = 'sdo';
    case SCHOOL = 'school';

    public function label(): string
    {
        return match ($this) {
            self::CO => 'Central Office',
            self::RO => 'Regional Office',
            self::SDO => 'Schools Division Office',
            self::SCHOOL => 'School',
        };
    }
}
