<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\Header;

class HeaderController extends BaseCrudController
{
    protected string $model = Header::class;
    protected string $folder = 'headers';
    protected string $permissionPrefix = 'admin.headers';
}
