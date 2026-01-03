@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Subjects</h1>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary mb-3">Add Subject</a>

        @if ($subjects->count())
            <table class="table  table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subjects as $s)
                        <tr>
                            <td>{{ $s->name }}</td>
                            <td>
                                <a href="{{ route('subjects.show', $s->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('subjects.edit', $s->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('subjects.destroy', $s->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No subjects found.</p>
        @endif
    </div>
@endsection
