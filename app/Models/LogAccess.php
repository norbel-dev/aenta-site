<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAccess extends Model
{
    protected $fillable = [
        'ip',
        'date',
        'block',
        'id_user',
    ];
}
