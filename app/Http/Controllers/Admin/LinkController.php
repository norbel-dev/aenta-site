<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\Link;

class LinkController extends BaseCrudController
{
    protected string $model = Link::class;
    protected string $folder = 'links';
    protected string $permissionPrefix = 'admin.links';

    public function index()
    {
        $links = Link::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        return view('admin.links.index', compact('links'));
    }
}
