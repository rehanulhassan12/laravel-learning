@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Class</h3>
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

            <form action="{{ route('classes.update', $class) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-2">
                    <label>School *</label>
                    <select name="school_id" class="form-control" required>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ old('school_id', $class->school_id) == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Class Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $class->name) }}"
                        required>
                </div>

                <div class="form-group mb-2">
                    <label>Section</label>
                    <input type="text" name="section" class="form-control" value="{{ old('section', $class->section) }}">
                </div>

                <div class="form-group mb-2">
                    <label>Session *</label>
                    <select name="session_year" class="form-control" required>
                        @foreach (['2022-2023', '2023-2024', '2024-2025'] as $session)
                            <option value="{{ $session }}"
                                {{ old('session_year', $class->session_year) == $session ? 'selected' : '' }}>
                                {{ $session }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button class="btn btn-warning">Update</button>
                <a href="{{ route('classes.index') }}" class="btn btn-secondary ml-2">Back</a>
            </form>
        </div>
    </div>
@endsection
