@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3 class="mb-3">Add Timetable Slot</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('timetables.store') }}" method="POST">
            @csrf

            <!-- School -->
            <div class="mb-3">
                <label class="form-label">School</label>
                <select name="school_id" id="school_id" class="form-select" required>
                    <option value="">Select School</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Class -->
            <div class="mb-3">
                <label class="form-label">Class</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    @foreach (\App\Models\ClassRoom::all() as $class)
                        <option value="{{ $class->id }}" data-school="{{ $class->school_id }}">
                            {{ $class->name }} | Section: {{ $class->section }} | Session: {{ $class->session_year }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Day -->
            <div class="mb-3">
                <label class="form-label">Day</label>
                <select name="day" class="form-select" required>
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                        <option value="{{ $day }}" {{ old('day') == $day ? 'selected' : '' }}>
                            {{ ucfirst($day) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Period -->
            <div class="mb-3">
                <label class="form-label">Period</label>
                <select name="period_id" id="period_id" class="form-select" required>
                    <option value="">Select Period</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}">{{ $period->name }} ({{ $period->start_time }} -
                            {{ $period->end_time }})</option>
                    @endforeach
                </select>
            </div>

            <!-- Subject -->
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">Select Subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Teacher -->
            <div class="mb-3">
                <label class="form-label">Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                    <option value="">Select Teacher</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Assign Slot</button>
            <a href="{{ route('timetables.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {

            function filterClasses() {
                const schoolId = $('#school_id').val();
                $('#class_id option').each(function() {
                    $(this).toggle($(this).data('school') == schoolId || $(this).val() == '');
                });
                $('#class_id').val('');
                $('#teacher_id').html('<option value="">Select Teacher</option>');
            }

            function fetchTeachers() {
                const schoolId = $('#school_id').val();
                const classId = $('#class_id').val();
                const subjectId = $('#subject_id').val();
                const day = $('select[name="day"]').val();
                const periodId = $('#period_id').val();

                if (!schoolId || !classId || !subjectId || !day || !periodId) {
                    $('#teacher_id').html('<option value="">Select Teacher</option>');
                    return;
                }

                $.getJSON("{{ url('timetables/available-teachers') }}", {
                    school_id: schoolId,
                    class_id: classId,
                    subject_id: subjectId,
                    day: day,
                    period_id: periodId
                }, function(data) {
                    let html = '<option value="">Select Teacher</option>';
                    $.each(data, function(i, t) {
                        html += `<option value="${t.id}">${t.name} — ${t.specialization}</option>`;
                    });
                    $('#teacher_id').html(html);
                });
            }

            // Events
            filterClasses(); // on page load
            $('#school_id').change(filterClasses);
            $('#school_id, #class_id, #subject_id, #period_id, select[name="day"]').change(fetchTeachers);
        });
    </script>

@endsection
