@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit School Group</h3>
        </div>

        <div class="card-body">
            {{-- Flash / Validation Errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('school_groups.update', $school_group) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group mb-2">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $school_group->name) }}"
                        required>
                </div>

                <div class="form-group mb-2">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control">{{ old('description', $school_group->description) }}</textarea>
                </div>

                <button type="submit" class="btn btn-warning">Update Group</button>
                <a href="{{ route('school_groups.index') }}" class=" pl- btn btn-secondary mt-2 ml-4">Back</a>

            </form>
        </div>
    </div>
@endsection
