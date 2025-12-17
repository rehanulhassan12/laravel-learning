@extends('layouts.admin')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('users.roles.update', $user->id) }}">
                @csrf
                @method('PUT')

                <h5>{{ $user->name }}</h5>

                @foreach ($roles as $role)
                    <div class="form-check">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                        <label>{{ $role->name }}</label>
                    </div>
                @endforeach

                <button class="btn btn-primary mt-2">Save Roles</button>
            </form>
        </div>
    </div>

@endsection
