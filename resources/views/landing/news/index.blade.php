@extends('landing-page')

@section('css')
<style>
    .card-img-top-a{
        max-height:25% !important;
        height:25% !important;
    }
    .card-img-top{
        height: 100%;
    }
    .card.dim-card{
        max-height: 80vh;
        height: 80vh;
    }
    .card-text.text-black-50{
        max-height: 82px;
    }

</style>
@endsection

@section('content')
    <a href="{{ route('index')}}" class="backlink">Volver</a>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center w-100">
                {{-- <div class="d-flex align-items-center gap-3"> --}}
                    {{ $news->links() }}
                {{-- </div> --}}
            </div>
            <div class="row g-4">
                @forelse ($news as $item)
                    <div class="col-md-4">
                        <div class="card dim-card hover-effect border-0">
                            <div class="card-img-top-a d-flex justify-content-center p-1">
                                    @if ($item->image)
                                        <a href="{{route ('show_news', $item)}}">
                                            <img class="card-img-top rounded" src="{{ asset('storage/'.$item->image) }}" alt="Card image cap">
                                        </a>
                                    @else
                                        <a class="d-flex justify-content-center align-items-middle" href="{{route ('show_news', $item)}}">
                                            <i class="bi bi-image-fill text-secondary rounded" style="font-size: 7rem;"></i>
                                        </a>
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
                                    <span class="text-black-50">
                                        <i class="bi bi-person me-1"></i>
                                        {{$item->user->name}}
                                    </span>
                                </div>
                                <div class="mb-1">
                                    <p class="card-text text-black-50 mb-1 text-break" style="white-space: pre-line;">
                                        {!! $item->content !!}
                                    </p>
                                </div>
                            </div>

                            <div class="card-footer py-3 bg-white text-muted">

                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center mt-3">No se encontraron resultados.</p>
                @endforelse
            </div>
            <div class="mt-4">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection
