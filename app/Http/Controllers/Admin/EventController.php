<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;

class EventController extends BaseCrudController
{
    protected string $model = Event::class;
    protected string $folder = 'events';
    protected string $permissionPrefix = 'admin.events';

    public function index()
    {
        //$events = Event::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        $events = Event::all();
        return view('admin.events.index', compact('events'));
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }
}
