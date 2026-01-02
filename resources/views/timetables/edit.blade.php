@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Edit Timetable Slot</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('timetables.update', $timetable->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Class</label>
                <select name="class_id" class="form-select" required>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ $timetable->class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Day</label>
                <select name="day" id="day" class="form-select" required>
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                        <option value="{{ $day }}" {{ $timetable->day == $day ? 'selected' : '' }}>
                            {{ ucfirst($day) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Period</label>
                <select name="period_id" id="period_id" class="form-select" required>
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}" {{ $timetable->period_id == $period->id ? 'selected' : '' }}>
                            {{ $period->name }} ({{ $period->start_time }} - {{ $period->end_time }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ $timetable->subject_id == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                    <option value="">Select Teacher</option>

                    <option value="{{ $timetable->teacher->id }}" selected>{{ $timetable->teacher->name }}</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Slot</button>
            <a href="{{ route('timetables.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchTeachers() {
                var subjectId = $('#subject_id').val();
                var day = $('#day').val();
                var periodId = $('#period_id').val();

                if (!subjectId || !day || !periodId) {
                    $('#teacher_id').html('<option value="">Select Teacher</option>');
                    return;
                }

                $.get("{{ route('timetables.available-teachers') }}", {
                    subject_id: subjectId,
                    day: day,
                    period_id: periodId
                }, function(data) {
                    var options = '<option value="">Select Teacher</option>';
                    $.each(data, function(i, t) {
                        options += '<option value="' + t.id + '" ' + (t.id ==
                                {{ $timetable->teacher_id }} ? 'selected' : '') + '>' + t.name +
                            '</option>';
                    });
                    $('#teacher_id').html(options);
                });
            }

            $('#subject_id, #day, #period_id').change(fetchTeachers);
        });
    </script>
@endsection
