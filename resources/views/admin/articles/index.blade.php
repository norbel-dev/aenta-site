@extends('adminlte::page')

@section('title', 'Articles')

@section('content_header')
    <h1>Articles</h1>
@endsection

@section('css')
<style>
    .card-img-top-a{
        max-height:48.44% !important;
        height:48.44% !important;
    }
    .card-img-top{
        height: 100%;
    }
    .card.dim-card{
        max-height: 578px;
        height: 578px;
    }
    .card-text.text-black-50{
        max-height: 82px;
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @can('admin.articles.create')
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary mb-3">Add New</a>
        @endcan
        <div class="row g-4 mt-4">
            @foreach($articles as $article)
                <div class="col-md-4">
                    <div class="card dim-card hover-effect border-0">
                        @if($article->thumbnail)
                        <a class="card-img-top-a" href="{{route('admin.articles.show', $article)}}">
                            <img class="card-img-top" src="{{ asset('storage/'.$article->thumbnail) }}" alt="Card image cap">
                        </a>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title fw-bold mb-2"><a href="{{route('admin.articles.show', $article)}}">{{ $article->title }}</a></h4>
                            <p class="mb-2 card-title-sub text-uppercase fw-normal ls1"><a href="{{route('admin.articles.show', $article)}}" class="text-black-50">{{$article->published_at}}</a></p>
                            <div class="rating-stars mb-2"><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star-half-full"></i> <span>otra cosa</span></div>
                            <p class="card-text text-black-50 mb-1">{{ Str::limit($article->content, 200) }}</p>
                        </div>
                        <div class="card-footer py-3 d-flex justify-content-between align-items-center bg-white text-muted">
                            <span class="badge bg-{{ $article->status->color() }}">{{ $article->status->label() }}</span>
                            @can('admin.articles.edit')
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-sm btn-primary">Editar</a>
                            @endcan
                            @can('admin.articles.destroy')
                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta artículo?')">Eliminar</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
