@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Students List</h3>
            <a href="{{ route('students.create') }}" class="btn btn-primary float-right">Add Student</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Roll No</th>
                        <th>Gender</th>
                        <th>DOB</th>
                        <th>Guardian</th>
                        <th>User Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->roll_no }}</td>
                            <td>{{ ucfirst($student->gender) }}</td>
                            <td>{{ $student->dob->format('Y-m-d') }}</td>
                            <td>{{ $student->guardian->name ?? '' }}</td>
                            <td>{{ $student->user->email ?? '' }}</td>
                            <td>
                                <a href="{{ route('students.show', $student) }}" class="btn btn-info btn-sm">View</a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('Delete?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
