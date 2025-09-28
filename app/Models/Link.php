<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'title',
        'link',
        'image',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => Status::class,
        ];
    }
}
