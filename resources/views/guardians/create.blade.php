@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Add Guardian</h3>
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

            <form action="{{ route('guardians.store') }}" method="POST">
                @csrf

                <input name="name" class="form-control mb-2" placeholder="Name" value="{{ old('name') }}">
                <input name="phone" class="form-control mb-2" placeholder="Phone" value="{{ old('phone') }}">
                <input name="email" class="form-control mb-2" placeholder="Email" value="{{ old('email') }}">
                <input name="relation" class="form-control mb-2" placeholder="Relation (Father/Mother)"
                    value="{{ old('relation') }}">
                <textarea name="address" class="form-control mb-2" placeholder="Address">{{ old('address') }}</textarea>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('guardians.index') }}" class="btn btn-secondary ml-2">Back</a>
            </form>
        </div>
    </div>
@endsection
