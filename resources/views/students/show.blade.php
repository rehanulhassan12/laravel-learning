@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Student Details</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            <p><strong>Email (User):</strong> {{ $student->user->email ?? '' }}</p>
            <p><strong>Roll No:</strong> {{ $student->roll_no }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($student->gender) }}</p>
            <p><strong>DOB:</strong> {{ $student->dob->format('Y-m-d') }}</p>
            <hr>
            <h5>Guardian Details</h5>
            <p><strong>Name:</strong> {{ $student->guardian->name ?? '' }}</p>
            <p><strong>Email:</strong> {{ $student->guardian->email ?? '' }}</p>
            <p><strong>Phone:</strong> {{ $student->guardian->phone ?? '' }}</p>
            <p><strong>Relation:</strong> {{ $student->guardian->relation ?? '' }}</p>
            <p><strong>Address:</strong> {{ $student->guardian->address ?? '' }}</p>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
