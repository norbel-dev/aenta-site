<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;

class EventController extends BaseCrudController
{
    protected string $model = Event::class;
    protected string $folder = 'events';
    protected string $permissionPrefix = 'admin.events';
}
