@extends('adminlte::page')

@section('title', 'Centers')

@section('content_header')
    <h1>Centers</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <a href="{{ route('admin.centers.create') }}" class="btn btn-primary mb-3">Add Center</a>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($centers as $center)
                <tr>
                    <td>{{ $center->name }}</td>
                    <td>{{ $center->contact }}</td>
                    <td>{{ $center->address }}</td>
                    <td>
                        <a href="{{ route('admin.centers.edit', $center) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.centers.destroy', $center) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this center?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
