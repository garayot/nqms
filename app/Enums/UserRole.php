<?php

namespace App\Enums;

enum UserRole: string
{
    case USER = 'user';
    case ADMIN = 'admin';
    case REVIEWER = 'reviewer';
    case APPROVER = 'approver';

    public function label(): string
    {
        return match ($this) {
            self::USER => 'User',
            self::ADMIN => 'Admin',
            self::REVIEWER => 'Reviewer',
            self::APPROVER => 'Approver',
        };
    }
}
