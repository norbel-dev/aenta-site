@extends('adminlte::page')

@section('title', 'News')

@section('content_header')
    <h1>News</h1>
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
    @livewire('admin.filter-index', [
        'model' => App\Models\News::class,
        'routePrefix' => 'admin.news'
    ])
@endsection
