@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Student Details</h3>
        </div>

        <div class="card-body">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>User:</strong> {{ $student->user->name ?? '-' }} ({{ $student->user->email ?? '-' }})</p>
            <p><strong>Roll No:</strong> {{ $student->roll_no ?? '-' }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
            <p><strong>Date of Birth:</strong> {{ $student->dob ?? '-' }}</p>

            <hr>

            <p><strong>Guardian:</strong> {{ $student->guardian->name }} ({{ $student->guardian->phone }})</p>
            <p><strong>Class:</strong> {{ $student->classRoom->name }} {{ $student->classRoom->section }}
                ({{ $student->classRoom->session_year }})</p>
            <p><strong>School:</strong> {{ $student->classRoom->school->name }}</p>

            <a href="{{ route('students.index') }}" class="btn btn-secondary mt-2">Back</a>
        </div>
    </div>
@endsection
