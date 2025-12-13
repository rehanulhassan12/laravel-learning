@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add School Group</h3>
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

            <form action="{{ route('school_groups.store') }}" method="POST">
                @csrf
                <div class="form-group mb-2">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="form-group mb-2">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Add Group</button>
                <a href="{{ route('school_groups.index') }}" class=" pl- btn btn-secondary mt-2 ml-4">Back</a>

            </form>
        </div>
    </div>
@endsection
