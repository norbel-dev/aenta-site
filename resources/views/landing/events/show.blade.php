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
    <a href="{{ route('events') }}" class="backlink">Volver a eventos</a>
    <div class="card dim-card hover-effect border-0">
        <div class="card-img-top-a d-flex justify-content-center p-1">
            @if ($event->image)
                <img class="card-img-top rounded" src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
            @else
                <i class="bi bi-image-fill text-secondary rounded" style="font-size: 7rem;"></i>
            @endif
        </div>
        <div class="card-body d-flex flex-column">
            <h1 class="card-title fw-bold">{{ $event->title }}</h1>
            <div class="mb-1 text-black-50">
                <i class="bi bi-calendar-date me-1"></i>
                {{ $event->event_date?->format('d-m-Y') ?? '---' }}
                @if ($event->event_date_end)
                    — {{ $event->event_date_end->format('d-m-Y') }}
                @endif
            </div>
            <div class="mb-1 text-black-50">
                <i class="bi bi-geo-alt me-1"></i>{{ $event->location }}
            </div>
            <div class="mb-3 text-black-50">
                <i class="bi bi-person me-1"></i>
                {{ $event->user?->name ?? 'Autor no disponible' }}
            </div>
            <div class="card-text text-break">{!! $event->description !!}</div>
        </div>
    </div>
@endsection
