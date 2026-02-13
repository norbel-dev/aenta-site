<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NewsController extends BaseCrudController
{
    protected string $model = News::class;
    protected string $folder = 'news';
    protected string $permissionPrefix = 'admin.news';
}
