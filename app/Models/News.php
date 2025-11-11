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

    public static array $filterable = [
        'title' => [
            'type' => 'text',
            'label' => 'Título',
        ],
        // 'published_at' => [
        //     'type' => 'date',
        //     'label' => 'Fecha de publicación',
        // ],
        'autor' => [
            'type' => 'relation',
            'label' => 'Autor',
            // no es necesario poner relation/target para autor porque el componente lo trata como user.name
        ],
        'status' => [
            'type' => 'select',
            'label' => 'Estado',
            'enum' => Status::class, // el componente cargará options vía enum::options()
        ],
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

