@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>User Details</h3>
        </div>

        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>

            <p><strong>Roles:</strong>
                @foreach ($user->roles as $role)
                    <span class="badge bg-info">{{ $role->name }}</span>
                @endforeach
            </p>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
