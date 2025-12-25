@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ isset($student) ? 'Edit' : 'Add' }} Student</h3>
        </div>
        <div class="card-body">
            <form action="{{ isset($student) ? route('students.update', $student) : route('students.store') }}"
                method="POST">
                @csrf
                @if (isset($student))
                    @method('PUT')
                @endif

                <label>Student Name</label>
                <input type="text" name="name" class="form-control mb-2" value="{{ old('name', $student->name ?? '') }}"
                    required>

                <label>User Email</label>
                <input type="email" name="user_email" class="form-control mb-2"
                    value="{{ old('user_email', $student->user->email ?? '') }}" required>

                <label>Roll No</label>
                <input name="roll_no" class="form-control mb-2" value="{{ old('roll_no', $student->roll_no ?? '') }}"
                    required>

                <label>Gender</label>
                <select name="gender" class="form-control mb-2" required>
                    <option value="male" {{ old('gender', $student->gender ?? '') == 'male' ? 'selected' : '' }}>Male
                    </option>
                    <option value="female" {{ old('gender', $student->gender ?? '') == 'female' ? 'selected' : '' }}>Female
                    </option>
                </select>

                <label>DOB</label>
                <input type="date" name="dob" class="form-control mb-2" value="{{ old('dob', $student->dob ?? '') }}"
                    required>

                <hr>
                <h5>Guardian Details</h5>
                <label>Guardian Name</label>
                <input type="text" name="guardian_name" class="form-control mb-2"
                    value="{{ old('guardian_name', $student->guardian->name ?? '') }}" required>

                <label>Guardian Email</label>
                <input type="email" name="guardian_email" class="form-control mb-2"
                    value="{{ old('guardian_email', $student->guardian->email ?? '') }}" required>

                <label>Guardian Phone</label>
                <input type="text" name="guardian_phone" class="form-control mb-2"
                    value="{{ old('guardian_phone', $student->guardian->phone ?? '') }}" required>

                <label>Guardian Relation</label>
                <input type="text" name="guardian_relation" class="form-control mb-2"
                    value="{{ old('guardian_relation', $student->guardian->relation ?? '') }}" required>

                <label>Guardian Address</label>
                <textarea name="guardian_address" class="form-control mb-2">{{ old('guardian_address', $student->guardian->address ?? '') }}</textarea>

                <button class="btn btn-primary">{{ isset($student) ? 'Update' : 'Save' }}</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
@endsection
