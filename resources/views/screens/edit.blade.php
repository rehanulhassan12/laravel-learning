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

                <input name="name" value="{{ old('name', $screen->name) }}" class="form-control">

                <button class="btn btn-primary mt-2">Update</button>
            </form>
        </div>
    </div>

@endsection
