@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">School Groups</h3>
            <a href="{{ route('school_groups.create') }}" class="btn btn-primary btn-sm">Add Group</a>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($groups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td>{{ $group->name }}</td>
                                <td title="{{ $group->description }}">
                                    {{ Str::limit($group->description, 50, '...') ?? '-' }}
                                </td>
                                <td>
                                    <a href="{{ route('school_groups.show', $group) }}" class="btn btn-sm btn-info">View</a>
                                    <a href="{{ route('school_groups.edit', $group) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('school_groups.destroy', $group) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete group?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
