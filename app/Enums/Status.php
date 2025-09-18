<?php

namespace App\Enums;

enum Status:int
{
    case EDIT_DRAFT = 1;
    case EDIT_PUBLISHED = 2;
    case EDIT_FINISHED = 3;
    case EDIT_CANCELLED = 4;
    public function label(): string
    {
        return match($this) {
            self::EDIT_DRAFT => 'Draft',
            self::EDIT_PUBLISHED => 'Published',
            self::EDIT_FINISHED => 'Finished',
            self::EDIT_CANCELLED => 'Cancelled',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::EDIT_DRAFT => "secondary",
            self::EDIT_PUBLISHED => "success",
            self::EDIT_FINISHED => "warning",
            self::EDIT_CANCELLED => "danger",
        };
    }

    public function isFinalized(): bool
    {
        return $this->value === self::EDIT_FINISHED;
        //return in_array($this, [self::COMPLETED, self::CANCELLED, self::REFUNDED]);
    }

    public function isCancelled(): bool
    {
        return $this->value === self::EDIT_CANCELLED;
        //return in_array($this, [self::COMPLETED, self::CANCELLED, self::REFUNDED]);
    }
}
