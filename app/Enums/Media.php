<?php

namespace App\Enums;

enum Media:int
{
    case NONE = 0;
    case PDF = 1;
    case AUDIO = 2;
    case VIDEO = 3;
    case EXTERNAL_LINK = 4;

    public function label(): string
    {
        return match($this) {
            self::NONE => 'Unassigned',
            self::PDF => 'Pdf',
            self::AUDIO => 'Audio',
            self::VIDEO => 'Video',
            self::EXTERNAL_LINK => 'Link',
        };
    }
}
