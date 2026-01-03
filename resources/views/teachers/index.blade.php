@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Teachers</h1>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary mb-3">Add Teacher</a>

        @if ($teachers->count())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Gender</th>
                        <th>Specialization</th>
                        <th>School</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $t)
                        <tr>
                            <td>{{ $t->name }}</td>
                            <td>{{ $t->phone }}</td>
                            <td>{{ $t->gender }}</td>
                            <td>{{ $t->specialization }}</td>
                            <td>{{ $t->school ? $t->school->name : '-' }}</td>
                            <td>
                                <a href="{{ route('teachers.show', $t) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('teachers.edit', $t) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('teachers.destroy', $t) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No teachers found.</p>
        @endif
    </div>
@endsection
