<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Models\News;

class NewsController extends BaseCrudController
{
    protected string $model = News::class;
    protected string $folder = 'news';
    protected string $permissionPrefix = 'admin.news';

    public function index()
    {
        $news = News::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        return view('admin.news.index', compact('news'));
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }
}
