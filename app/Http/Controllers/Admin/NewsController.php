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

    public function index()
    {
        $user = User::find(Auth::id());
        if ($user->isAdmin() || $user->isSuperAdmin()){
            $news = News::with('user')->orderByDesc('published_at')->get();
            return view('admin.news.index', compact('news'));
        }
        $news = $user->news()->orderByDesc('published_at')->get();
        return view('admin.news.index', compact('news'));
    }
}
