@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Class Details</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $class->id }}</td>
                </tr>
                <tr>
                    <th>School</th>
                    <td>{{ $class->school->name }}</td>
                </tr>
                <tr>
                    <th>Class</th>
                    <td>{{ $class->name }}</td>
                </tr>
                <tr>
                    <th>Section</th>
                    <td>{{ $class->section ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Session</th>
                    <td>{{ $class->session_year }}</td>
                </tr>
            </table>

            <a href="{{ route('classes.index') }}" class="btn btn-secondary mt-2">Back</a>
        </div>
    </div>
@endsection
