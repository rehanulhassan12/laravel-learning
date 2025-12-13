@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit User</h3>
        </div>

        <div class="card-body">
            {{-- Flash/Error messages --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
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

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-2">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                </div>

                <div class="form-group mb-2">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>

                <div class="form-group mb-2">
                    <label for="password">Password <small>(leave blank to keep current)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-warning">Update User</button>
                <a href="{{ route('users.index') }}" class=" pl- btn btn-secondary mt-2 ml-4">Back</a>

            </form>
        </div>
    </div>
@endsection
