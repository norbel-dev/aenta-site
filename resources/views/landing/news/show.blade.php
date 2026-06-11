@extends('landing-page')

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
    <a href="{{ route('index')}}" class="backlink">Volver</a>
    <div class="card dim-card hover-effect border-0">
        <div class="card-img-top-a d-flex justify-content-center p-1">
            @if($news->image)
                <img class="card-img-top rounded" src="{{ asset('storage/'.$news->image) }}" alt="Card image cap">
            @else
                <i class="bi bi-image-fill text-secondary rounded" style="font-size: 7rem;"></i>
            @endif
        </div>
        <div class="card-body d-flex flex-column">
            <div class="mb-1">
                <h4 class="card-title fw-bold">
                    {{ $news->title ?? '(Sin título)' }}
                </h4>
            </div>
            <div class="mb-1">
                <span class="text-black-50">
                    <i class="bi bi-calendar-date me-1"></i>
                    {{ isset($news->published_at) ? \Carbon\Carbon::parse($news->published_at)->format('d-m-Y') : '---' }}
                </span>
            </div>
            <div class="mb-1">
                <span class="text-black-50">
                    <i class="bi bi-person me-1"></i>
                    {{$news->user->name}}
                </span>
            </div>
            <p class="card-text text-black-50 mb-1 text-break" style="white-space: pre-line;">
                {!! $news->content !!}
            </p>
        </div>
    </div>
@endsection
