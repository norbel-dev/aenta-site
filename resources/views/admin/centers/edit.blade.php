@extends('adminlte::page')

@section('title', 'Edit Center')

@section('content_header')
    <h1>Edit Center</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.centers.update', $center) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}" required>
            </div>

            <div class="form-group mb-3">
                <label for="mission">Mission</label>
                <textarea name="mission" class="form-control" rows="4">{{ old('mission') }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="vision">Vision</label>
                <textarea name="vision" class="form-control" rows="4">{{ old('vision') }}</textarea>
            </div>

            <div class="form-group mb-3">
                <label for="contact">Contact</label>
                <input type="text" name="contact" class="form-control"
                       value="{{ old('contact') }}">
            </div>

            <div class="form-group mb-3">
                <label for="address">Address</label>
                <input type="text" name="address" class="form-control"
                       value="{{ old('address') }}">
            </div>

            <button type="submit" class="btn btn-success">Update</button>
            <a href="{{ route('admin.centers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
