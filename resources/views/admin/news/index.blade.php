@extends('adminlte::page')

@section('title', 'News')

@section('content_header')
    <h1>News</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @can('admin.news.create')
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary mb-3">Add New</a>
        @endcan
        {{-- <table class="table table-bordered table-striped table-responsive">
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
            @foreach($news as $item)
                <tr>
                    <td><a href="{{route('admin.news.show', $item)}}">{{ $item->title }}</a></td>
                    <td>{{ $item->content }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status->color() }}">{{ $item->status->label() }}</span>
                    </td>
                    <td>{{ $item->published_at }}</td>
                    <td>
                        @can('admin.news.edit')
                            <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('admin.news.destroy')
                            <form action="{{ route('admin.news.destroy', $item) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this new?')">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table> --}}
        @foreach($news as $noticia)
            <div class="card mb-3 p-3">
                <h4>{{ $noticia->titulo }}</h4>
                @if($noticia->thumbnail)
                    <img src="{{ asset('storage/'.$noticia->thumbnail) }}" title="{{ asset('storage/'.$noticia->thumbnail) }}" style="max-width: 200px;">
                @endif
                <p>{{ Str::limit($noticia->content, 200) }}</p>
                <a href="{{ route('admin.news.edit', $noticia) }}" class="btn btn-sm btn-primary">Editar</a>

                <form action="{{ route('admin.news.destroy', $noticia) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta noticia?')">Eliminar</button>
                </form>
            </div>
        @endforeach
    </div>
</div>
@endsection
