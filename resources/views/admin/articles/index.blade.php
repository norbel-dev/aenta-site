@extends('adminlte::page')

@section('title', 'Events')

@section('content_header')
    <h1>Events</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary mb-3">Add Event</a>
        <table class="table table-bordered table-striped">
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
                        {{-- @if($event->status == $status->EDIT_DRAFT)
                            <span class="badge bg-success">Published</span>
                        @elseif($event->status == 'draft')
                            <span class="badge bg-secondary">Draft</span>
                        @else
                            <span class="badge bg-danger">Cancelled</span>
                        @endif --}}
                    </td>
                    <td>
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this event?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
