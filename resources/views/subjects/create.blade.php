@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Add Subject</h1>

        <form action="{{ route('subjects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Subject</button>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
