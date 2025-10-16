@extends('adminlte::page')

@section('title', 'Events')

@section('content_header')
    <h1>Events</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @can('admin.events.create')
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">Add Event</a>
        @endcan
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->title }}</td>
                    <td>{{ $event->event_date }}</td>
                    <td>{{ $event->event_date_end ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $event->status->color() }}">{{ $event->status->label() }}</span>
                    </td>
                    <td>
                        @can('admin.events.edit')
                            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('admin.events.destroy')
                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this event?')">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
