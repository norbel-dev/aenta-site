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
                @forelse ($headers as $header)
                    <div class="col-md-4">
                        <div class="card dim-card hover-effect border-0">
                            <div class="card-img-top-a d-flex justify-content-center p-1">
                                <a href="{{ route('show_header', $header) }}">
                                    @if ($header->image)
                                        <img class="card-img-top rounded"
                                            src="{{ asset('storage/' . $header->image) }}"
                                            alt="{{ $header->title }}">
                                    @else
                                        <i class="bi bi-image-fill text-secondary rounded" style="font-size: 7rem;"></i>
                                    @endif
                                </a>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h4 class="card-title fw-bold">{{ $header->title }}</h4>
                                <div class="mb-1 text-black-50">
                                    <i class="bi bi-calendar-date me-1"></i>
                                    {{ $header->published_at ? \Carbon\Carbon::parse($header->published_at)->format('d-m-Y') : '---' }}
                                </div>
                                <div class="mb-1 text-black-50">
                                    <i class="bi bi-person me-1"></i>
                                    {{ $header->user?->name ?? 'Autor no disponible' }}
                                </div>
                                <p class="card-text text-black-50 mb-1 text-break" style="white-space: pre-line;">
                                    {!! $header->content !!}
                                </p>
                                <a class="mt-auto" href="{{ route('show_header', $header) }}">Ver header</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center mt-3">No se encontraron resultados.</p>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $headers->links() }}
            </div>
        </div>
    </div>
@endsection
