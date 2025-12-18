@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Class</h3>
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

            <form action="{{ route('classes.store') }}" method="POST">
                @csrf

                <div class="form-group mb-2">
                    <label>School *</label>
                    <select name="school_id" class="form-control" required>
                        <option value="">Select School</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label>Class Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mb-2">
                    <label>Section</label>
                    <input type="text" name="section" class="form-control" value="{{ old('section') }}">
                </div>

                <div class="form-group mb-2">
                    <label>Session *</label>
                    <select name="session_year" class="form-control" required>
                        <option value="">Select Session</option>
                        <option value="2022-2023" {{ old('session_year') == '2022-2023' ? 'selected' : '' }}>2022-2023
                        </option>
                        <option value="2023-2024" {{ old('session_year') == '2023-2024' ? 'selected' : '' }}>2023-2024
                        </option>
                        <option value="2024-2025" {{ old('session_year') == '2024-2025' ? 'selected' : '' }}>2024-2025
                        </option>
                    </select>
                </div>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('classes.index') }}" class="btn btn-secondary ml-2">Back</a>
            </form>
        </div>
    </div>
@endsection
