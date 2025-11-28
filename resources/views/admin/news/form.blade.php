@extends('adminlte::page')

@section('title', $item->exists ? 'Edit News' : 'Create News')

@section('content_header')
    <h1>Edit News</h1>
@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <link href="{{ URL::asset('css/datepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    @if (session('info'))
        <div class="alert alert-success">
            <strong>{{session('info')}}</strong>
        </div>
    @endif
    <form method="POST"
          action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($item->exists)
            @method('PUT')
        @endif

        <div>
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control" >
            @error('title')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div class="mt-3">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" required>{{ old('content', $item->content) }}</textarea>
            @error('content')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <div class="row g-4 mt-1">
            <div class="col-md-4">
                <div class="form-group mt-3">
                    <label for="image">Image</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @php
                        $currentImage = $item->exists ? $item->image : null;
                        $preview = $currentImage
                            ? asset('storage/' . $currentImage)
                            : null;
                    @endphp

                    <div class="mb-3 text-center">
                        @if ($preview)
                            <img id="preview"
                                src="{{ $preview }}"
                                style="max-width:200px;border-radius:10px;">
                        @else
                            <i id="preview" class="bi bi-image-fill text-secondary" style="font-size: 7rem;"></i>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-3">
                    <label for="status">Status</label>
                    <div class="input-group">
                        <select name="status" class="form-control">
                            @foreach(App\Enums\Status::cases() as $status)
                                <option value="{{ $status->value }}" @selected(old('status') == $status->value || ($item->exists && $item->status->value == $status->value))>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-3">
                    <label for="published_at">Published at</label>
                        <div class="input-group align-items-center">
                            <input type="text" name="published_at" class="form-control campo-fecha" placeholder="dd-mm-yyyy"
                                value="{{null !== old('published_at') ? date('d-m-Y', strtotime(old('published_at'))) : date('d-m-Y', strtotime($item->published_at))}}" required>
                            <i class="bi bi-calendar-date ml-1"></i>
                        </div>
                    @error('published_at')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            {{ $item->exists ? 'Actualizar' : 'Guardar' }}
        </button>
    </form>
</div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
    <script src="{{ URL::asset('js/datepicker.js') }}"></script>
    <script src="{{ URL::asset('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            imagePreview();
            let minDate = new Date();
            minDate.setFullYear(minDate.getFullYear() - 1);
            initializeDatePicker(minDate);

            $('textarea[name=content]').summernote({
                height: 300,
                toolbar: [
                    ['edit', ['undo', 'redo']],
                    ['style', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol']],
                    ['insert', ['link']]
                ]
            });
        });
    </script>
@endsection
