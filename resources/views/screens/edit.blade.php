@extends('layouts.admin')

@section('content')

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('screens.update', $screen->id) }}">
                @csrf
                @method('PUT')
                <input name="name" class="form-control" value="{{ old('name', $screen->name) }}">
                <input name="route_name" class="form-control mt-2" value="{{ old('route_name', $screen->route_name) }}">
                <input name="icon" class="form-control mt-2" value="{{ old('icon', $screen->icon) }}">
                <select name="parent_id" class="form-control mt-2">
                    <option value="">-- Parent (optional) --</option>
                    @foreach ($parents as $p)
                        <option value="{{ $p->id }}" {{ $screen->parent_id == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary mt-2">Update</button>
            </form>

        </div>
    </div>

@endsection
