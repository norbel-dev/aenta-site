@extends('adminlte::page')

@section('title', 'Create Header')

@section('content_header')
    <h1>Create Header</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.headers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="content">Content</label>
                <textarea name="content" class="form-control" rows="4">{{ old('content') }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="image">Image</label><br>
                {{-- @if($headers->image) --}}
                    <img src="{{ asset('storage/') }}" alt="New Image" class="img-thumbnail mb-2" width="200">
                {{-- @endif --}}
                <input type="file" name="image" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="status">Status</label>
                <select name="status" class="form-control">
                    @foreach(App\Enums\Status::cases() as $status)
                        <option value="{{ $status->value }}" @selected(old('status') == $status->value)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="published_at">Published at</label>
                <input type="date" name="published_at" class="form-control"
                       value="{{ old('published_at') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Create</button>
            <a href="{{ route('admin.headers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
