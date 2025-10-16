@extends('adminlte::page')

@section('title', 'Convocatories')

@section('content_header')
    <h1>Convocatories</h1>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        @can('admin.convocatories.create')
            <a href="{{ route('admin.convocatories.create') }}" class="btn btn-primary mb-3">Add New</a>
        @endcan
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>media</th>
                    <th>date</th>
                    <th>date end</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($convocatories as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->media }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->date_end }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status->color() }}">{{ $item->status->label() }}</span>
                    </td>
                    <td>
                        @can('admin.convocatories.edit')
                            <a href="{{ route('admin.convocatories.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                        @endcan
                        @can('admin.convocatories.destroy')
                            <form action="{{ route('admin.convocatories.destroy', $item) }}" method="POST" style="display:inline-block;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this new?')">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
