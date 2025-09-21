<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Status;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Enum;

class NewsController extends Controller
{
    public function index()
    {
        $newss = News::where('status', Status::EDIT_PUBLISHED)->latest()->get();
        return view('admin.news.index', compact('newss'));
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'status' => 'required', new Enum(Status::class),
            'published_at' => 'required|date',
        ]);

        News::create($request->all());
        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'status' => 'required', new Enum(Status::class),
            'published_at' => 'required|date',
        ]);

        $news->update($request->all());
        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    public function destroy(News $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }
}
