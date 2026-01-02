@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-3">Add Timetable Slot</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('timetables.store') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Class</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Day</label>
                <select name="day" class="form-select" required>
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                        <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>{{ ucfirst($day) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Period</label>
                <select name="period_id" id="period_id" class="form-select" required>
                    <option value="">Select Period</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>
                            {{ $period->name }} ({{ $period->start_time }} - {{ $period->end_time }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">Select Subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                    <option value="">Select Teacher</option>
                    {{-- Options will be filled dynamically based on selected subject and availability --}}
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Assign Slot</button>
            <a href="{{ route('timetables.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchTeachers() {
                var subjectId = $('#subject_id').val();
                var day = $('select[name="day"]').val();
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
                        options += '<option value="' + t.id + '">' + t.name + '</option>';
                    });
                    $('#teacher_id').html(options);
                });
            }

            $('#subject_id, select[name="day"], #period_id').change(fetchTeachers);
        });
    </script>

@endsection
