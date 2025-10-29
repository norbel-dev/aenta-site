<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\Header;

class HeaderController extends BaseCrudController
{
    protected string $model = Header::class;
    protected string $folder = 'headers';
    protected string $permissionPrefix = 'admin.headers';

    public function index()
    {
        $headers = Header::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        return view('admin.headers.index', compact('headers'));
    }
}
