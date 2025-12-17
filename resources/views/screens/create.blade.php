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
            <form method="POST" action="{{ route('screens.store') }}">
                @csrf
                <input name="name" value="{{ old('name') }}" class="form-control" placeholder="Screen name">
                <button class="btn btn-primary mt-2">Save</button>
            </form>
        </div>
    </div>

@endsection
