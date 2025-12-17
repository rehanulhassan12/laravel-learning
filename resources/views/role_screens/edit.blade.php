@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Assign Screens to {{ $role->name }}</h3>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('roles.screens.update', $role->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group">
                    @foreach ($screens as $screen)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="screens[]" value="{{ $screen->id }}"
                                id="screen{{ $screen->id }}" {{ $role->screens->contains($screen->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="screen{{ $screen->id }}">
                                {{ $screen->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary mt-3">Save Screens</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Cancel</a>
            </form>
        </div>
    </div>
@endsection
