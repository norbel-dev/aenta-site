<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Article extends Model
{
    protected $fillable = [
        'title',
        'abstract',
        'content',
        'author',
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
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'abstract' => 'string',
            'author' => 'string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required', new Enum(Status::class),
            'published_at' => 'required|date',
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
