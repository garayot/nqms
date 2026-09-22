<?php

namespace App\Enums;

enum DrafStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case UNDER_REVIEW = 'under_review';
    case RECOMMENDED_FOR_APPROVAL = 'recommended_for_approval';
    case REVIEW_DISAPPROVED = 'review_disapproved';
    case APPROVED = 'approved';
    case APPROVAL_DISAPPROVED = 'approval_disapproved';
    case REGISTERED = 'registered';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::SUBMITTED => 'Submitted',
            self::UNDER_REVIEW => 'Under Review',
            self::RECOMMENDED_FOR_APPROVAL => 'Recommended for Approval',
            self::REVIEW_DISAPPROVED => 'Review Disapproved',
            self::APPROVED => 'Approved',
            self::APPROVAL_DISAPPROVED => 'Approval Disapproved',
            self::REGISTERED => 'Registered',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::DRAFT => 'bg-slate-100 text-slate-700',
            self::SUBMITTED => 'bg-blue-100 text-blue-700',
            self::UNDER_REVIEW => 'bg-amber-100 text-amber-700',
            self::RECOMMENDED_FOR_APPROVAL => 'bg-indigo-100 text-indigo-700',
            self::REVIEW_DISAPPROVED => 'bg-rose-100 text-rose-700',
            self::APPROVED => 'bg-emerald-100 text-emerald-700',
            self::APPROVAL_DISAPPROVED => 'bg-red-100 text-red-700',
            self::REGISTERED => 'bg-cyan-100 text-cyan-700',
        };
    }
}
