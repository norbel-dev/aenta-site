@extends('adminlte::page')

@section('title', $item->exists ? 'Edit Event' : 'Create Event')

@section('content_header')
    <h1>{{$item->exists ? 'Edit Event' : 'Create Event'}}</h1>
@endsection

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" rel="stylesheet">
    <link href="{{ URL::asset('css/datepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <form method="POST"
          action="{{ $item->exists ? route('admin.events.update', $item) : route('admin.events.store') }}"
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
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ old('description', $item->description) }}</textarea>
            @error('description')
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
                    <label for="event_date">Date</label>
                    <div class="input-group align-items-center">
                        <input type="text" name="event_date" class="form-control campo-fecha" placeholder="dd-mm-yyyy"
                            value="{{null !== old('event_date') ? date('d-m-Y', strtotime(old('event_date'))) : date('d-m-Y', strtotime($item->event_date))}}" required>
                        <i class="bi bi-calendar-date ml-1"></i>
                    </div>
                    @error('event_date')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-3">
                    <label for="event_date_end">Date end</label>
                    <div class="input-group align-items-center">
                        <input type="text" name="event_date_end" class="form-control campo-fecha" placeholder="dd-mm-yyyy"
                            value="{{null !== old('event_date_end') ? date('d-m-Y', strtotime(old('event_date_end'))) : date('d-m-Y', strtotime($item->event_date_end))}}" required>
                        <i class="bi bi-calendar-date ml-1"></i>
                    </div>
                    @error('event_date_end')
                        <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group mt-3">
                    <label for="location">Location</label>
                    <input type="text" name="location" value="{{ old('location', $item->location) }}" class="form-control" required>
                    @error('location')
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
            let maxDate = new Date();
            maxDate.setFullYear(maxDate.getFullYear() + 1);
            initializeDatePicker(new Date(), maxDate);

            $('textarea[name=description]').summernote({
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
