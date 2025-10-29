@extends('adminlte::page')

@section('title', $item->exists ? 'Edit News' : 'Create News')

@section('content_header')
    <h1>Edit News</h1>
@endsection

@section('content')
<div class="container">
    <form method="POST"
          action="{{ $item->exists ? route('admin.news.update', $item) : route('admin.news.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($item->exists)
            @method('PUT')
        @endif

        <div>
            <label for="title">Title</label>
            <input type="text" name="title" value="{{ old('title', $item->title) }}" class="form-control" required>
        </div>

        <div class="mt-3">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" required>{{ old('content', $item->content) }}</textarea>
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
                <select name="status" class="form-control">
                    @foreach(App\Enums\Status::cases() as $status)
                        <option value="{{ $status->value }}" @selected(old('status') == $status->value)>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mt-3">
                <label for="published_at">Published at</label>
                <input type="date" name="published_at" class="form-control"
                       value="{{ old('published_at') }}" required>
            </div>

        <button type="submit" class="btn btn-primary mt-3">
            {{ $item->exists ? 'Actualizar' : 'Guardar' }}
        </button>
    </form>
</div>

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
</script>
@endsection
