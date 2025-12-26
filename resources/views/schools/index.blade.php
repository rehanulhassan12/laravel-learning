@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Schools</h3>

            @if (auth()->user()->roles->contains('name', 'admin'))
                <a href="{{ route('schools.create') }}" class="btn btn-primary btn-sm">Add School</a>
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
                            <th>School Group</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schools as $school)
                            <tr>
                                <td>{{ $school->id }}</td>
                                <td>{{ $school->group->name ?? '-' }}</td>
                                <td>{{ $school->name }}</td>
                                <td>{{ $school->address ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('schools.show', $school) }}" class="btn btn-sm btn-info">View</a>

                                    @if (auth()->user()->roles->contains('name', 'admin'))
                                        <a href="{{ route('schools.edit', $school) }}"
                                            class="btn btn-sm btn-warning">Edit</a>

                                        <form action="{{ route('schools.destroy', $school) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger"
                                                onclick="return confirm('Delete school?')">
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
