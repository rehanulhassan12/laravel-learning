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
                    <label for="school_id">School <span class="text-danger">*</span></label>
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
                    <label for="name">Class Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mb-2">
                    <label for="section">Section</label>
                    <input type="text" name="section" class="form-control" value="{{ old('section') }}">
                </div>

                <button type="submit" class="btn btn-primary">Add Class</button>
                <a href="{{ route('classes.index') }}" class=" pl- btn btn-secondary mt-2 ml-4">Back</a>

            </form>
        </div>
    </div>
@endsection
