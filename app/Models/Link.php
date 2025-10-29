<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasSlugRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Link extends Model
{
    use HasSlugRouteKey;

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

    static function rules(){
        return [
            'title' => 'required|string|max:255',
            'link' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required', new Enum(Status::class),
        ];
    }
}
