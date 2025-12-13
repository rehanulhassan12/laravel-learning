@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Classes</h3>
            <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">Add Class</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>School</th>
                            <th>Class Name</th>
                            <th>Section</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                            <tr>
                                <td>{{ $class->id }}</td>
                                <td>{{ $class->school->name }}</td>
                                <td>{{ $class->name }}</td>
                                <td>{{ $class->section ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('classes.destroy', $class) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete class?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
