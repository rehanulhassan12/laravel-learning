@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Timetable</h1>
        <a href="{{ route('timetables.create') }}" class="btn btn-primary mb-3">Add Timetable Slot</a>

        @if ($timetables->count())
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Class</th>
                        <th>Day</th>
                        <th>Period</th>
                        <th>Subject</th>
                        <th>Teacher</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($timetables as $t)
                        <tr>
                            <td>{{ $t->classRoom->name }}</td>
                            <td>{{ ucfirst($t->day) }}</td>
                            <td>{{ $t->period->name }} ({{ $t->period->start_time }} - {{ $t->period->end_time }})</td>
                            <td>{{ $t->subject->name }}</td>
                            <td>{{ $t->teacher->name }}</td>
                            <td>
                                <a href="{{ route('timetables.edit', $t->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('timetables.destroy', $t->id) }}" method="POST"
                                    style="display:inline;">
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
            <p class="text-muted">No timetable slots assigned yet.</p>
        @endif
    </div>
@endsection
