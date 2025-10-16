@extends('adminlte::page')

@section('title', 'Articles')

@section('content_header')
    <h1>Articles</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @can('admin.articles.create')
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary mb-3">Add Article</a>
        @endcan
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)
                <tr>
                    <td>{{ $article->title }}</td>
                    <td>{{ $article->author }}</td>
                    <td>
                        <span class="badge bg-{{ $article->status->color() }}">{{ $article->status->label() }}</span>
                    </td>
                    <td>{{ $article->published_at ?? '-' }}</td>
                    <td>
                        @can('admin.articles.edit')
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('admin.articles.destroy')
                            <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this article?')">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
