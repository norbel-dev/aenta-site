@extends('adminlte::page')

@section('title', 'Create Event')

@section('content_header')
    <h1>Create Event</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="event_date">Start Date</label>
                <input type="date" name="event_date" class="form-control"
                       value="{{ old('event_date') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="event_date_end">End Date</label>
                <input type="date" name="event_date_end" class="form-control"
                       value="{{ old('event_date_end') }}">
            </div>

            <div class="form-group mb-3">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control"
                       value="{{ old('location') }}">
            </div>

            <div class="form-group mb-3">
                <label for="image">Image</label><br>
                {{-- @if($event->image) --}}
                    <img src="{{ asset('storage/') }}" alt="Event Image" class="img-thumbnail mb-2" width="200">
                {{-- @endif --}}
                <input type="file" name="image" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="status">Status</label>
                {{-- <select name="status" class="form-control">
                    <option value={{App\Enums\Status::EDIT_DRAFT}} {{ old('status', $event->status) == App\Enums\Status::EDIT_DRAFT ? 'selected' : '' }}>Draft</option>
                    <option value={{App\Enums\Status::EDIT_PUPLISHED}} {{ old('status', $event->status) == App\Enums\Status::EDIT_PUPLISHED ? 'selected' : '' }}>Published</option>
                    <option value={{App\Enums\Status::EDIT_FINISHED}}{{ old('status', $event->status) == App\Enums\Status::EDIT_FINISHED ? 'selected' : '' }}>Cancelled</option>
                </select> --}}
                <select name="status" class="form-control">
                    @foreach(App\Enums\Status::cases() as $status)
                        <option value="{{ $status->value }}" @selected(old('status') == $status->value)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
