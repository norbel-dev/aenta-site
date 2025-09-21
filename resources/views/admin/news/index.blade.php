@extends('adminlte::page')

@section('title', 'News')

@section('content_header')
    <h1>News</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary mb-3">Add New</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($newss as $news)
                <tr>
                    <td>{{ $news->title }}</td>
                    <td>{{ $news->content }}</td>
                    <td>
                        <span class="badge bg-{{ $news->status->color() }}">{{ $news->status->label() }}</span>
                        {{-- @if($new->status == $status->EDIT_DRAFT)
                            <span class="badge bg-success">Published</span>
                        @elseif($new->status == 'draft')
                            <span class="badge bg-secondary">Draft</span>
                        @else
                            <span class="badge bg-danger">Cancelled</span>
                        @endif --}}
                    </td>
                    <td>{{ $news->published_at }}</td>
                    <td>
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.news.destroy', $news) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this new?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
