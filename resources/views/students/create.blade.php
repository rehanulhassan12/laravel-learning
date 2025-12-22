@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Add Student</h3>
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

            <form action="{{ route('students.store') }}" method="POST">
                @csrf

                <input name="name" class="form-control mb-2" placeholder="Student Name" value="{{ old('name') }}">
                <input name="roll_no" class="form-control mb-2" placeholder="Roll No" value="{{ old('roll_no') }}">

                <select name="gender" class="form-control mb-2">
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>

                <input type="date" name="dob" class="form-control mb-2" value="{{ old('dob') }}">

                <label>User (optional)</label>
                <select name="user_id" class="form-control mb-2">
                    <option value="">Select User</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>

                <label>Guardian</label>
                <select name="guardian_id" class="form-control mb-2">
                    <option value="">Select Guardian</option>
                    @foreach ($guardians as $guardian)
                        <option value="{{ $guardian->id }}" {{ old('guardian_id') == $guardian->id ? 'selected' : '' }}>
                            {{ $guardian->name }} - {{ $guardian->phone }} ({{ $guardian->relation }})
                        </option>
                    @endforeach
                </select>

                <label>Class</label>
                <select name="class_id" class="form-control mb-2">
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->school->name }} | {{ $class->name }} {{ $class->section }}
                            ({{ $class->session_year }})
                        </option>
                    @endforeach
                </select>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary ml-2">Back</a>
            </form>
        </div>
    </div>
@endsection
