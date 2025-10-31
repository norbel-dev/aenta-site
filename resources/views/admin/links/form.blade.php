@extends('adminlte::page')

@section('title', $item->exists ? 'Edit Link' : 'Create Link')

@section('content_header')
    <h1>Edit Link</h1>
@endsection

@section('css')
    <link href="{{ URL::asset('css/datepicker.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="container">
    <form method="POST"
          action="{{ $item->exists ? route('admin.links.update', $item) : route('admin.links.store') }}"
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

        <div class="mt-3">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">

            <div class="mt-2">
                <img id="preview"
                     src="{{ $item->image ? asset('storage/'.$item->image) : '' }}"
                     style="max-width: 200px; border-radius: 10px; {{ $item->image ? '' : 'display:none;' }}">
            </div>
        </div>

        <div class="form-group mt-3">
            <label for="status">Status</label>
            <div class="col-sm-4">
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

        <div class="form-group mt-3">
            <label for="published_at">Published at</label>
            <div class="col-sm-4">
                <div class="input-group">
                    <input type="text" name="published_at" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose"
                        value="{{null !== old('published_at') ? date('d/m/Y', strtotime(old('published_at'))) : date('d/m/Y', strtotime($item->published_at))}}" required>
                    <span class="input-group-addon bg-primary b-0 text-white"><i class="fas fa-fw fa-calendar"></i></span>
                </div><!-- input-group -->
            </div>
            @error('published_at')
                <small class="text-danger">{{$message}}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary mt-3">
            {{ $item->exists ? 'Actualizar' : 'Guardar' }}
        </button>
    </form>
</div>
@endsection

@section('js')
    <script src="{{ URL::asset('js/datepicker.js') }}"></script>
    <script>
        document.getElementById('image').addEventListener('change', (e) => {
            const file = e.target.files[0];
            const preview = document.getElementById('preview');
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                preview.src = ev.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
        jQuery('#datepicker-autoclose').datepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
            todayHighlight: true
        });
    </script>
@endsection
