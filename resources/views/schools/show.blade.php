@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">School Details</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $school->id }}</td>
                </tr>
                <tr>
                    <th>School Group</th>
                    <td>{{ $school->group->name }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $school->name }}</td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td>{{ $school->address ?? '-' }}</td>
                </tr>
            </table>

            <a href="{{ route('schools.index') }}" class="btn btn-secondary mt-2">Back</a>
        </div>
    </div>
@endsection
