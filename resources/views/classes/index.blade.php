@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Classes</h3>

            @if (auth()->user()->roles->contains('name', 'admin'))
                <a href="{{ route('classes.create') }}" class="btn btn-primary btn-sm">Add Class</a>
            @endif
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
                            <th>Class</th>
                            <th>Section</th>
                            <th>Session</th>
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
                                <td>{{ $class->session_year }}</td>
                                <td>
                                    <a href="{{ route('classes.show', $class) }}" class="btn btn-sm btn-info">View</a>

                                    @if (auth()->user()->roles->contains('name', 'admin'))
                                        <a href="{{ route('classes.edit', $class) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('classes.destroy', $class) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete class?')">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
