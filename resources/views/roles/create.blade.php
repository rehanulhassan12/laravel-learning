@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Create Role</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('roles.store') }}">
                @csrf

                <div class="mb-2">
                    <label>Role Name</label>
                    <input name="name" class="form-control">
                </div>

                <label>Screens</label>
                @foreach ($screens as $screen)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="screens[]" value="{{ $screen->id }}">
                        <label class="form-check-label">
                            {{ $screen->name }}
                        </label>
                    </div>
                @endforeach

                <button class="btn btn-primary mt-3">Save</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Back</a>
            </form>
        </div>
    </div>
@endsection
