@extends('adminlte::page')

@section('title', 'Links')

@section('content_header')
    <h1>Links</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @can('admin.links.create')
            <a href="{{ route('admin.links.create') }}" class="btn btn-primary mb-3">Add New</a>
        @endcan
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Link</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($links as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->link }}</td>
                    <td>{{ $item->image }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status->color() }}">{{ $item->status->label() }}</span>
                    </td>

                    <td>
                        @can('admin.links.edit')
                            <a href="{{ route('admin.links.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('admin.links.destroy')
                            <form action="{{ route('admin.links.destroy', $item) }}" method="POST" style="display:inline-block;">
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
