@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Edit Guardian</h3>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('guardians.update', $guardian) }}" method="POST">
                @csrf @method('PUT')

                <input name="name" class="form-control mb-2" value="{{ old('name', $guardian->name) }}">
                <input name="phone" class="form-control mb-2" value="{{ old('phone', $guardian->phone) }}">
                <input name="email" class="form-control mb-2" value="{{ old('email', $guardian->email) }}">
                <input name="relation" class="form-control mb-2" value="{{ old('relation', $guardian->relation) }}">
                <textarea name="address" class="form-control mb-2">{{ old('address', $guardian->address) }}</textarea>

                <button class="btn btn-warning">Update</button>
                <a href="{{ route('guardians.index') }}" class="btn btn-secondary ml-2">Back</a>
            </form>
        </div>
    </div>
@endsection
