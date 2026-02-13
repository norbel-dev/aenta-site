<?php

namespace App\Models;

use App\Enums\Media;
use App\Enums\Status;
use App\Traits\HasSlugRouteKey;
use Illuminate\Database\Eloquent\Model;

class Convocatory extends Model
{
    use HasSlugRouteKey;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'media',
        'archivo',
        'date',
        'date_end',
        'status',
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
            'enum' => Status::class,
        ],
        'media' => [
            'type' => 'select',
            'label' => 'Tipo de archivo',
            'enum' => Media::class,
        ],
    ];

    public static array $filterableAdmin = [
        'autor' => [
            'type' => 'relation',
            'label' => 'Autor',
        ],
    ];

    public static array $dateRangeFields = [
        'date',
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
                'field' => 'date',
                'label' => 'Comienza',
                'type' => 'date',
                'order' => 3
            ],
            [
                'field' => 'date_end',
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
                'field' => 'description',
                'label' => 'Descripción',
                'type' => 'html',
                'order' => 6
            ],
        ];
    }

    protected $casts = [
        'status' => Status::class,
        'media'=> Media::class
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
