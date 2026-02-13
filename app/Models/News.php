<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasSlugRouteKey;
use Carbon\Carbon;
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
        'thumbnail',
        'status',
        'published_at',
        'user_id',
    ];

    public static array $filterable = [
        'title' => [
            'type' => 'text',
            'label' => 'Título',
        ],
        'status' => [
            'type' => 'select',
            'label' => 'Estado',
            'enum' => Status::class, // el componente cargará options vía enum::options()
        ],
    ];

    public static array $filterableAdmin = [
        'autor' => [
            'type' => 'relation',
            'label' => 'Autor',
            // no es necesario poner relation/target para autor porque el componente lo trata como user.name
        ],
    ];

    public static array $dateRangeFields = [
        'published_at',
    ];

    public function getCardSchema()
    {
        return [
            [
                'field' => 'image',
                'label' => null,
                'type' => 'image',
                'order' => 1
            ],
            [
                'field' => 'title',
                'label' => null,
                'type' => 'title',
                'order' => 2
            ],
            [
                'field' => 'published_at',
                'label' => 'Publicado',
                'type' => 'date',
                'order' => 3
            ],
            [
                'field' => 'user.name',
                'label' => 'Autor',
                'type' => 'relation',
                'order' => 4
            ],
            [
                'field' => 'content',
                'label' => 'Contenido',
                'type' => 'html',
                'order' => 5
            ],
        ];
    }

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

