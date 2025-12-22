@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Guardian Details</h3>
        </div>

        <div class="card-body">
            <p><strong>Name:</strong> {{ $guardian->name }}</p>
            <p><strong>Phone:</strong> {{ $guardian->phone }}</p>
            <p><strong>Email:</strong> {{ $guardian->email ?? '-' }}</p>
            <p><strong>Relation:</strong> {{ ucfirst($guardian->relation) }}</p>
            <p><strong>Address:</strong> {{ $guardian->address ?? '-' }}</p>

            <a href="{{ route('guardians.index') }}" class="btn btn-secondary mt-2">Back</a>
        </div>
    </div>
@endsection
