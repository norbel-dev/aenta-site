<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class ArticleController extends Controller
{
    public function index()
    {
        //$articles = Article::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        $articles = Article::all();
        return view('admin.articles.index', compact('articles'));
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function create()
    {
        return view('admin.articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'abstract' => 'required',
            'author' => 'required',
            'status' => 'required', new Enum(Status::class),
            'published_at' => 'required|date',
        ]);

        Article::create($request->all());
        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'abstract' => 'required',
            'author' => 'required',
            'status' => 'required', new Enum(Status::class),
            'published_at' => 'required|date',
        ]);

        $article->update($request->all());
        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}
