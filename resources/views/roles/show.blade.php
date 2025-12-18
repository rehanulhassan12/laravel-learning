@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Role Details</h3>
        </div>

        <div class="card-body">
            <p><strong>Name:</strong> {{ $role->name }}</p>

            <p><strong>Screens:</strong></p>
            @foreach ($role->screens as $screen)
                <span class="badge bg-info">{{ $screen->name }}</span>
            @endforeach

            <div class="mt-3">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('roles.edit', $role) }}" class="btn btn-warning">Edit</a>
            </div>
        </div>
    </div>
@endsection
