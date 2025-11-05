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
        'media',
        'date',
        'date_end',
        'status',
    ];

    protected $casts = [
        'status' => Status::class,
        'media'=> Media::class
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
