@extends('layouts.front')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome to {{ $center->name }}</h1>
    <p class="lead">{{ $center->mission }}</p>

    {{-- News Section --}}
    <h2 class="mt-5">Latest News</h2>
    <div class="row">
        @foreach($news as $item)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5>{{ $item->title }}</h5>
                        <p>{{ Str::limit($item->content, 80) }}</p>
                        <a href="{{route('show_news', $item)}}" class="btn btn-sm btn-outline-primary">Read more</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Events Section --}}
    <h2 class="mt-5">Upcoming Events</h2>
    <ul class="list-group">
        @foreach($events as $event)
            <li class="list-group-item">
                <strong>{{ $event->title }}</strong>
                ({{ $event->event_date }}
                @if($event->event_date_end) - {{ $event->event_date_end }} @endif)
                — {{ $event->location }}
            </li>
        @endforeach
    </ul>

    {{-- Articles Section --}}
    <h2 class="mt-5">Articles</h2>
    @foreach($articles as $article)
        <div class="mb-3">
            <h5>{{ $article->title }}</h5>
            <p>{{ $article->abstract }}</p>
            <a href="{{route('show_article', $article)}}" class="btn btn-sm btn-outline-secondary">Read full article</a>
        </div>
    @endforeach
</div>
@endsection
