<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
