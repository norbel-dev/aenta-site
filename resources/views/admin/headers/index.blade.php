@extends('adminlte::page')

@section('title', 'Headers')

@section('content_header')
    <h1>Headers</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @can('admin.headers.create')
            <a href="{{ route('admin.headers.create') }}" class="btn btn-primary mb-3">Add New</a>
        @endcan
        <table class="table table-bordered table-striped table-responsive">
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
            @foreach($headers as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->content }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status->color() }}">{{ $item->status->label() }}</span>
                    </td>
                    <td>{{ $item->published_at }}</td>
                    <td>
                        @can('admin.headers.edit')
                            <a href="{{ route('admin.headers.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('admin.headers.destroy')
                            <form action="{{ route('admin.headers.destroy', $item) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this new?')">Delete</button>
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
