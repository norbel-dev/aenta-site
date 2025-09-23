<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Article;
use App\Models\Center;
use App\Models\Event;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'center' => Center::first(),
            'news' => News::where('status', Status::EDIT_PUBLISHED)->latest()->take(3)->get(),
            'events' => Event::where('status', Status::EDIT_PUBLISHED)->orderBy('event_date', 'asc')->take(3)->get(),
            'articles' => Article::where('status', Status::EDIT_PUBLISHED)->latest()->take(2)->get(),
        ]);
    }

    public function show_article(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function show_center(Center $center)
    {
        return view('admin.centers.show', compact('center'));
    }

    public function show_event(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    public function show_news(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

}
