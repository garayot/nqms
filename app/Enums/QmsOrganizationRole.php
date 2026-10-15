<?php

namespace App\Enums;

enum QmsOrganizationRole: string
{
    case SDS = 'sds';
    case ASDS = 'asds';
    case QMR = 'qmr';
    case SECRETARIAT_TEAM_LEAD = 'secretariat_team_lead';
    case SECRETARIAT_TEAM_MEMBER = 'secretariat_team_member';

    public function label(): string
    {
        return match ($this) {
            self::SDS => 'SDS',
            self::ASDS => 'ASDS',
            self::QMR => 'QMR (Quality Management Representative)',
            self::SECRETARIAT_TEAM_LEAD => 'QMS Secretariat Team Lead',
            self::SECRETARIAT_TEAM_MEMBER => 'QMS Secretariat Team Member',
        };
    }

    public function isSingleton(): bool
    {
        return $this !== self::SECRETARIAT_TEAM_MEMBER;
    }
}
