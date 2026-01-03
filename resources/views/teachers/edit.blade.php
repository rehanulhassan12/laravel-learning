@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Edit Teacher</h1>

        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->name) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="user_email" class="form-control"
                    value="{{ old('user_email', $teacher->user->email ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select" required>
                    <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Female
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Specialization</label>
                <input type="text" name="specialization" class="form-control"
                    value="{{ old('specialization', $teacher->specialization) }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="{{ old('dob', $teacher->dob) }}">
            </div>

            <div class="mb-3">
                <label class="form-label">School</label>
                <select name="school_id" class="form-select" required>
                    <option value="">Select School</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}"
                            {{ old('school_id', $teacher->school_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update Teacher</button>
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
