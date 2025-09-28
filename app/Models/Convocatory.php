<?php

namespace App\Models;

use App\Enums\Media;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;

class Convocatory extends Model
{
    protected $fillable = [
        'title',
        'media',
        'date',
        'date_end',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
        'media'=> Media::class
    ];

    // protected function casts(): array
    // {
    //     return [
    //         'status' => Status::class,
    //     ];
    // }
}
