@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Subject</h1>

        <form action="{{ route('subjects.update', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $subject->name) }}" required>
            </div>

            <button type="submit" class="btn btn-success">Update Subject</button>
            <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
