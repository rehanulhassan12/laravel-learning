@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">School Group Details</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $school_group->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $school_group->name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $school_group->description ?? '-' }}</td>
                </tr>
            </table>

            <a href="{{ route('school_groups.index') }}" class="btn btn-secondary mt-2">Back</a>
        </div>
    </div>
@endsection
