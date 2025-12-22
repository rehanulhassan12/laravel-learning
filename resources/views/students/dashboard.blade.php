@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Student Dashboard</h3>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $student->name }}</p>
            {{-- <p><strong>Email:</strong> {{ $student->user->email }}</p> --}}
            <p><strong>Class:</strong> {{ $student->classRoom->name ?? '-' }}</p>
            <p><strong>Section:</strong> {{ $student->classRoom->section ?? '-' }}</p>
            <p><strong>Session:</strong> {{ $student->classRoom->session_year ?? '-' }}</p>
            <p><strong>Guardian:</strong> {{ $student->guardian->name ?? '-' }}</p>
            <p><strong>Guardian Contact:</strong> {{ $student->guardian->phone ?? '-' }}</p>
        </div>
    </div>
@endsection
