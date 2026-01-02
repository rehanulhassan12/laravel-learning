@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Subject Details</h1>
        <p><strong>Name:</strong> {{ $subject->name }}</p>
        <a href="{{ route('subjects.index') }}" class="btn btn-secondary">Back</a>
    </div>
@endsection
