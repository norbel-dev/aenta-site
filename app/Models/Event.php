<?php

namespace App\Models;

use App\Enums\Status;
use App\Traits\HasSlugRouteKey;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Event extends Model
{
    use HasSlugRouteKey;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'event_date',
        'event_date_end',
        'location',
        'image',
        'thumbnail',
        'status',
        'user_id',
    ];

    public static array $filterable = [
        'title' => [
            'type' => 'text',
            'label' => 'Título',
        ],
        'location' => [
            'type' => 'text',
            'label' => 'Localización',
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
        ],
    ];

    public static array $dateRangeFields = [
        'event_date',
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
                'field' => 'event_date',
                'label' => 'Comienza',
                'type' => 'date',
                'order' => 3
            ],
            [
                'field' => 'event_date_end',
                'label' => 'Termina',
                'type' => 'date',
                'order' => 4
            ],
            [
                'field' => 'user.name',
                'label' => 'Autor',
                'type' => 'relation',
                'order' => 5
            ],
            [
                'field' => 'location',
                'label' => 'Localización',
                'type' => 'location',
                'order' => 6
            ],
            [
                'field' => 'description',
                'label' => 'Contenido',
                'type' => 'html',
                'order' => 7
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
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_date_end' => 'nullable|date|after_or_equal:event_date',
            'location' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required', new Enum(Status::class),
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
