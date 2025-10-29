<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasSlugRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Header extends Model
{
    use HasSlugRouteKey;

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

    static function rules(){
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required', new Enum(Status::class),
            'published_at' => 'required|date',
        ];
    }
}
