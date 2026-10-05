@extends('landing-page')

@section('css')
<style>
    .card-img-top-a {
        max-height: 35% !important;
        height: 35% !important;
    }
    .card-img-top {
        height: 100%;
        max-width: 30%;
        width: 30%;
    }
</style>
@endsection

@section('content')
    <a href="{{ route('headers') }}" class="backlink">Volver a headers</a>
    <div class="card dim-card hover-effect border-0">
        <div class="card-img-top-a d-flex justify-content-center p-1">
            @if ($header->image)
                <img class="card-img-top rounded"
                    src="{{ asset('storage/' . $header->image) }}"
                    alt="{{ $header->title }}">
            @else
                <i class="bi bi-image-fill text-secondary rounded" style="font-size: 7rem;"></i>
            @endif
        </div>
        <div class="card-body d-flex flex-column">
            <h1 class="card-title fw-bold">{{ $header->title }}</h1>
            <div class="mb-1 text-black-50">
                <i class="bi bi-calendar-date me-1"></i>
                {{ $header->published_at ? \Carbon\Carbon::parse($header->published_at)->format('d-m-Y') : '---' }}
            </div>
            <div class="mb-3 text-black-50">
                <i class="bi bi-person me-1"></i>
                {{ $header->user?->name ?? 'Autor no disponible' }}
            </div>
            <div class="card-text text-break">{!! $header->content !!}</div>
        </div>
    </div>
@endsection
