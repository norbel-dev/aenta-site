@extends('landing-page')

@section('css')
<style>
    .card-img-top-a {
        max-height: 25% !important;
        height: 25% !important;
    }
    .card-img-top {
        height: 100%;
    }
    .card.dim-card {
        max-height: 80vh;
        height: 80vh;
    }
    .card-text.text-black-50 {
        max-height: 82px;
    }
</style>
@endsection

@section('content')
    <a href="{{ route('index') }}" class="backlink">Volver</a>
    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                @forelse ($events as $event)
                    <div class="col-md-4">
                        <div class="card dim-card hover-effect border-0">
                            <div class="card-img-top-a d-flex justify-content-center p-1">
                                <a href="{{ route('show_event', $event) }}">
                                    @if ($event->image)
                                        <img class="card-img-top rounded"
                                            src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}">
                                    @else
                                        <i class="bi bi-image-fill text-secondary rounded" style="font-size: 7rem;"></i>
                                    @endif
                                </a>
                            </div>

                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title fw-bold">{{ $event->title }}</h4>
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
                                <div class="mb-1 text-black-50">
                                    <i class="bi bi-person me-1"></i>
                                    {{ $event->user?->name ?? 'Autor no disponible' }}
                                </div>
                                <p class="card-text text-black-50 mb-1 text-break" style="white-space: pre-line;">
                                    {!! $event->description !!}
                                </p>
                                <a class="mt-auto" href="{{ route('show_event', $event) }}">Ver evento</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center mt-3">No se encontraron resultados.</p>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $events->links() }}
            </div>
        </div>
    </div>
@endsection
