@extends('adminlte::page')

@section('title', 'Convocatories')

@section('content_header')
    <h1>Convocatories</h1>
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
        @can('admin.convocatories.create')
            <a href="{{ route('admin.convocatories.create') }}" class="btn btn-primary mb-3">Add New</a>
        @endcan
        <div class="row g-4 mt-4">
            @foreach($convocatories as $convocatory)
                <div class="col-md-4">
                    <div class="card dim-card hover-effect border-0">
                        @if($convocatory->thumbnail)
                        <a class="card-img-top-a" href="{{route('admin.convocatories.show', $convocatory)}}">
                            <img class="card-img-top" src="{{ asset('storage/'.$convocatory->thumbnail) }}" alt="Card image cap">
                        </a>
                        @endif
                        <div class="card-body">
                            <h4 class="card-title fw-bold mb-2"><a href="{{route('admin.convocatories.show', $convocatory)}}">{{ $convocatory->title }}</a></h4>
                            <p class="mb-2 card-title-sub text-uppercase fw-normal ls1"><a href="{{route('admin.convocatories.show', $convocatory)}}" class="text-black-50">{{$convocatory->published_at}}</a></p>
                            <div class="rating-stars mb-2"><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star3"></i><i class="icon-star-half-full"></i> <span>otra cosa</span></div>
                            <p class="card-text text-black-50 mb-1">{{ Str::limit($convocatory->content, 200) }}</p>
                        </div>
                        <div class="card-footer py-3 d-flex justify-content-between align-items-center bg-white text-muted">
                            <span class="badge bg-{{ $convocatory->status->color() }}">{{ $convocatory->status->label() }}</span>
                            @can('admin.convocatories.edit')
                                <a href="{{ route('admin.convocatories.edit', $convocatory) }}" class="btn btn-sm btn-primary">Editar</a>
                            @endcan
                            @can('admin.convocatories.destroy')
                                <form action="{{ route('admin.convocatories.destroy', $convocatory) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta convocatory?')">Eliminar</button>
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
