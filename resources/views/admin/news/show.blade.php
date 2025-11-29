@extends('adminlte::page')

@section('title', 'News details')

@section('content_header')
    <h1>News details</h1>
@endsection

@section('css')
<style>
    .card-img-top-a{
        max-height:35% !important;
        height:35% !important;
    }
    .card-img-top{
        height: 100%;
        max-width: 30%;
        width: 30%
    }
</style>
@endsection

@section('content')
    <div class="card dim-card hover-effect border-0">
        <div class="card-img-top-a d-flex justify-content-center p-1">
            @if($item->thumbnail)
                <img class="card-img-top rounded" src="{{ asset('storage/'.$item->thumbnail) }}" alt="Card image cap">
            @else
                <i class="bi bi-image-fill text-secondary rounded" style="font-size: 7rem;"></i>
            @endif
        </div>
        <div class="card-body d-flex flex-column">
            <div class="mb-1">
                <h4 class="card-title fw-bold">
                    {{ $item->title ?? '(Sin título)' }}
                </h4>
            </div>
            <div class="mb-1">
                <span class="text-black-50">
                    <i class="bi bi-calendar-date me-1"></i>
                    {{ isset($item->published_at) ? \Carbon\Carbon::parse($item->published_at)->format('d-m-Y') : '---' }}
                </span>
            </div>
            <div class="mb-1">
                <i class="bi bi-person me-1"></i>
                <span>{{$item->user->name}}</span>
            </div>
            <p class="card-text text-black-50 mb-1 text-break" style="white-space: pre-line;">
                {!! $item->content !!}
            </p>
        </div>
        <div class="card-footer py-3 bg-white text-muted">
            <div class="d-flex justify-content-between align-items-center w-100">
                <span class="badge bg-{{ $item->status->color() }}">
                    {{ $item->status->label() }}
                </span>
                <div class="d-flex align-items-center gap-2">
                    @can('admin.news.edit')
                        <a href="{{ route('admin.news.edit', $item) }}"
                        class="btn btn-sm btn-primary"
                        title="Editar">
                            <i class="bi bi-pencil-fill"></i>
                        </a>
                    @endcan

                    @can('admin.news.destroy')
                        <form action="{{ route('admin.news.destroy', $item) }}"
                            method="POST" class="m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Eliminar esta noticia?')"
                                    title="Eliminar">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </form>
                    @endcan
                </div>

            </div>
        </div>
    </div>
@endsection
