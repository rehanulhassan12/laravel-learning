@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between">
            <h3>Guardians</h3>
            <a href="{{ route('guardians.create') }}" class="btn btn-primary btn-sm">Add Guardian</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <table class="table table-bordered">
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Relation</th>
                    <th>Actions</th>
                </tr>

                @foreach ($guardians as $guardian)
                    <tr>
                        <td>{{ $guardian->name }}</td>
                        <td>{{ $guardian->phone }}</td>
                        <td>{{ ucfirst($guardian->relation) }}</td>
                        <td>
                            <a href="{{ route('guardians.show', $guardian) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('guardians.edit', $guardian) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('guardians.destroy', $guardian) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete guardian?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection
