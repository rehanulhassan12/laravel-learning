@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit User</h3>
        </div>

        <div class="card-body">
            {{-- Success Message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-2">
                    <label>Name</label>
                    <input name="name" class="form-control" value="{{ old('name', $user->name) }}">
                </div>

                <div class="mb-2">
                    <label>Email</label>
                    <input name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>

                <div class="mb-2">
                    <label>Password (optional)</label>
                    <input type="password" name="password" class="form-control">
                </div>

                {{-- ROLES CHECKBOXES --}}
                <div class="mb-2">
                    <label>Roles</label>
                    @foreach ($roles as $role)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}"
                                {{ in_array($role->id, old('roles', $userRoles)) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $role->name }}</label>
                        </div>
                    @endforeach
                </div>

                <button class="btn btn-warning">Update</button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary mt-2">Back</a>
            </form>
        </div>
    </div>
@endsection
