@extends('adminlte::page')

@section('title', 'Links')

@section('content_header')
    <h1>Links</h1>
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
        @can('admin.links.create')
            <a href="{{ route('admin.links.create') }}" class="btn btn-primary mb-3">Add New</a>
        @endcan
        <div class="row g-4 mt-4">
            @foreach($links as $link)
                <div class="col-md-4">
                    <div class="card dim-card hover-effect border-0">
                        @if($link->thumbnail)
                        <a class="card-img-top-a" href="{{route('admin.links.show', $link)}}">
                            <img class="card-img-top" src="{{ asset('storage/'.$link->thumbnail) }}" alt="Card image cap">
                        </a>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title fw-bold mb-2"><a href="{{route('admin.links.show', $link)}}">{{ $link->title }}</a></h4>
                            <p class="mb-2 card-title-sub text-uppercase fw-normal ls1"><a href="{{route('admin.links.show', $link)}}" class="text-black-50">{{$link->published_at}}</a></p>
                            <div class="rating-stars mb-2"><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star-half-full"></i> <span>otra cosa</span></div>
                            <p class="card-text text-black-50 mb-1">{{ Str::limit($link->content, 200) }}</p>
                        </div>
                        <div class="card-footer py-3 d-flex justify-content-between align-items-center bg-white text-muted">
                            <span class="badge bg-{{ $link->status->color() }}">{{ $link->status->label() }}</span>
                            @can('admin.links.edit')
                                <a href="{{ route('admin.links.edit', $link) }}" class="btn btn-sm btn-primary">Editar</a>
                            @endcan
                            @can('admin.links.destroy')
                                <form action="{{ route('admin.links.destroy', $link) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta link?')">Eliminar</button>
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
