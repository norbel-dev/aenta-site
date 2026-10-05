@extends('landing-page')

@section('content')
<div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @forelse ($headers as $item)
                    <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $item->image) }}" class="d-block w-100" alt="...">
                        @if($item->title || $item->subtitle)
                            <div class="carousel-caption d-none d-md-block">
                                @if($item->title)
                                    <h5>{{ $item->title }}</h5>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="carousel-item active">
                        {{-- <img src="{{ asset('img/default-header.jpg') }}" class="d-block w-100" alt="..."> --}}
                        <div class="carousel-caption d-none d-md-block">
                            <h5>No hay imágenes para el carrusel.</h5>
                        </div>
                    </div>
                @endforelse
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    <div class="main-container container-fluid">
        <div class="row g-4 mt-4">
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Importante, novedoso</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($novedoso as $item)
                            <li class="list-group-item">{{ $item->title }}</li>
                        @empty
                            <li class="list-group-item">No hay items.</li>
                        @endforelse
                    </ul>
                    @if(isset($novedoso) && $novedoso->count() > 3)
                        <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Noticias</h5>
                    @if(isset($noticias) && $noticias->count() > 3)
                    <ul class="list-group list-group-flush">
                        @for ($i=0; $i < 3; $i++)
                            <li class="list-group-item"><a href="{{ route ('show_news', $noticias[$i]) }}" class="card-link">{{ $noticias[$i]->title }}</a></li>
                        @endfor
                    </ul>
                        <a href="{{ route ('news') }}" class="mt-auto">mostrar más...</a>
                    @else
                    <ul class="list-group list-group-flush">
                        @forelse($noticias as $item)
                            <li class="list-group-item"><a href="{{ route ('show_news', $item) }}" class="card-link">{{ $item->title }}</a></li>
                        @empty
                            <li class="list-group-item">No hay noticias.</li>
                        @endforelse
                    </ul>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Eventos</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($eventos as $item)
                            <li class="list-group-item">{{ $item->title }}</li>
                        @empty
                            <li class="list-group-item">No hay eventos.</li>
                        @endforelse
                    </ul>
                    @if(isset($eventos) && $eventos->count() > 3)
                    <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Convocatorias</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($convocatorias as $item)
                            <li class="list-group-item">{{ $item->title }}</li>
                        @empty
                            <li class="list-group-item">No hay convocatorias.</li>
                        @endforelse
                    </ul>
                    @if(isset($convocatorias) && $convocatorias->count() > 3)
                        <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Servicios</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($servicios as $item)
                            <li class="list-group-item">{{ $item->name }}</li>
                        @empty
                            <li class="list-group-item">No hay servicios.</li>
                        @endforelse
                    </ul>
                    @if(isset($servicios) && $servicios->count() > 3)
                        <a href="#" class="card-link mt-auto">mostrar más...</a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="card content-card">
                    <h5 class="card-title">Productos</h5>
                    <ul class="list-group list-group-flush">
                         <li class="list-group-item">No hay productos.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="section-bar mt-1">
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/catedes.png') }}" alt="CATEDES Logo" title="CATEDES">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/cea.png') }}" alt="CEA Logo" title="CEA">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/ceac.png') }}" alt="CEAC Logo" title="CEAC">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/ceaden.png') }}" alt="CEADEN Logo" title="CEADEN">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/cenais.png') }}" alt="CENAIS Logo" title="CENAIS">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/centis.png') }}" alt="CENTIS Logo" title="CENTIS">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/ciac.png') }}" alt="CIAC Logo" title="CIAC">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/cies.png') }}" alt="CIES Logo" title="CIES">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/cphr.png') }}" alt="CPHR Logo" title="CPHR">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/cubaenergia.png') }}" alt="CUBAENERGIA Logo" title="CUBAENERGIA">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/icimaf.png') }}" alt="ICIMAF Logo" title="ICIMAF">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/idict.png') }}" alt="IDICT Logo" title="IDICT">
            </a>
        </div>
        <div class="section-bar mt-1">
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/logo-arcal.png') }}" alt="ARCAL Logo" title="ARCAL">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/logo-citma.jpg') }}" alt="CITMA Logo" title="CITMA">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/minsap-logo.jpg') }}" alt="MINSAP Logo" title="MINSAP">
            </a>
            <a class="section-bar-link" href="#">
                <img src="{{ asset('img/links/oiea.jpg') }}" alt="OIEA Logo" title="OIEA">
            </a>
        </div>
    </div>
@endsection
