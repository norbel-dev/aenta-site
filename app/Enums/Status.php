<?php

namespace App\Enums;

enum Status:int
{
    case EDIT_DRAFT = 1;
    case EDIT_PUBLISHED = 2;
    case EDIT_FINISHED = 3;
    case EDIT_CANCELLED = 4;
    case EDIT_VERY_IMPORTANT = 5;

    public function label(): string
    {
        return match($this) {
            self::EDIT_DRAFT => 'Draft',
            self::EDIT_PUBLISHED => 'Published',
            self::EDIT_FINISHED => 'Finished',
            self::EDIT_CANCELLED => 'Cancelled',
            self::EDIT_VERY_IMPORTANT => 'Very Important',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::EDIT_DRAFT => "secondary",
            self::EDIT_PUBLISHED => "primary",
            self::EDIT_FINISHED => "warning",
            self::EDIT_CANCELLED => "danger",
            self::EDIT_VERY_IMPORTANT => 'success',
        };
    }

    public static function options(): array
    {
        $opts = [];
        foreach (self::cases() as $case) {
            $opts[$case->value] = $case->label();
        }
        return $opts;
    }

    public function isFinalized(): bool
    {
        return $this->value === self::EDIT_FINISHED;
    }

    public function isCancelled(): bool
    {
        return $this->value === self::EDIT_CANCELLED;
    }
}
