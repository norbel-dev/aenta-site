<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;

class ArticleController extends BaseCrudController
{
    protected string $model = Article::class;
    protected string $folder = 'articles';
    protected string $permissionPrefix = 'admin.articles';

    public function index()
    {
        //$articles = Article::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        $articles = Article::all();
        return view('admin.articles.index', compact('articles'));
    }
}
