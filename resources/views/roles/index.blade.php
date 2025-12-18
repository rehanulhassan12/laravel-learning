@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Roles</h3>
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Add Role</a>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Screens</th>
                    <th>Actions</th>
                </tr>

                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach ($role->screens as $screen)
                                <span class="badge bg-info">{{ $screen->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('roles.destroy', $role) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
