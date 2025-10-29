<?php

namespace App\Traits;

trait HasSlugRouteKey
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
