<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasSlugRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class News extends Model
{
    use HasSlugRouteKey;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'published_at',
        'user_id',
    ];

    public static array $filterable =  [
        'title' => ['type' => 'text', 'label' => 'Título'],
        'status' => ['type' => 'select', 'label' => 'Estado', 'options' => [1 => 'Borrador', 2 => 'Publicado', 3 => 'Cancelado', 4 => 'Finalizado', 5 => 'Muy Importante']],
        'published_at' => ['type' => 'date', 'label' => 'Fecha de publicación'],
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

    public function user(){
        return $this->belongsTo(User::class);
    }
}

