@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Students</h3>
            <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">Add Student</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>User</th>
                    <th>Guardian</th>
                    <th>Class</th>
                    <th>School</th>
                    <th>Actions</th>
                </tr>

                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->user->name ?? '-' }} ({{ $student->user->email ?? '-' }})</td>
                        <td>{{ $student->guardian->name }} ({{ $student->guardian->phone }})</td>
                        <td>{{ $student->classRoom->name }} {{ $student->classRoom->section }}
                            ({{ $student->classRoom->session_year }})</td>
                        <td>{{ $student->classRoom->school->name }}</td>
                        <td>
                            <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete student?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
