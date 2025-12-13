@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit School</h3>
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

            <form action="{{ route('schools.update', $school) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-2">
                    <label for="school_group_id">School Group <span class="text-danger">*</span></label>
                    <select name="school_group_id" class="form-control" required>
                        <option value="">Select Group</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}"
                                {{ old('school_group_id', $school->school_group_id) == $group->id ? 'selected' : '' }}>
                                {{ $group->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-2">
                    <label for="name">School Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $school->name) }}"
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control"
                        value="{{ old('address', $school->address) }}">
                </div>

                <button type="submit" class="btn btn-warning">Update School</button>
                <a href="{{ route('schools.index') }}" class=" pl- btn btn-secondary mt-2 ml-4">Back</a>

            </form>
        </div>
    </div>
@endsection
