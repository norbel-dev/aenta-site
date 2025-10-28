<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Enum;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'event_date_end',
        'location',
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
            'description' => 'required|string',
            'event_date' => 'required|date',
            'event_date_end' => 'nullable|date|after_or_equal:event_date',
            'location' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required', new Enum(Status::class),
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
