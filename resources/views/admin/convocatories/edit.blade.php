@extends('adminlte::page')

@section('title', 'Edit Convocatory')

@section('content_header')
    <h1>Edit Convocatory</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.convocatories.update', $convocatory) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control"
                       value="{{ old('title') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="media">Media</label>
                <select name="media" class="form-control">
                    @foreach(App\Enums\Media::cases() as $media)
                        <option value="{{ $media->value }}" @selected(old('media') == $media->value)>
                            {{ $media->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="date">Date</label>
                <input type="date" name="date" class="form-control"
                       value="{{ old('date') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="date_end">Date end (optional)</label>
                <input type="date" name="date_end" class="form-control"
                       value="{{ old('date_end') }}" required>
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
            <a href="{{ route('admin.convocatories.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
