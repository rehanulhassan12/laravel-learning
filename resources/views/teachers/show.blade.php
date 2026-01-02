@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Teacher Details</h1>

        <div class="card p-3 mb-3">
            <p><strong>Name:</strong> {{ $teacher->name }}</p>
            <p><strong>Phone:</strong> {{ $teacher->phone ?? '-' }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($teacher->gender) }}</p>
            <p><strong>Specialization:</strong> {{ $teacher->specialization }}</p>
            <p><strong>Date of Birth:</strong> {{ $teacher->dob ?? '-' }}</p>
        </div>

        <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-warning">Edit</a>
    </div>
@endsection
