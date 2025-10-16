@extends('adminlte::page')

@section('title', 'Edit Link')

@section('content_header')
    <h1>Edit Link</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.links.update', $links) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="link">Link</label>
                <textarea name="link" class="form-control" rows="4">{{ old('link') }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="image">Image</label><br>
                {{-- @if($links->image) --}}
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

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.links.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
