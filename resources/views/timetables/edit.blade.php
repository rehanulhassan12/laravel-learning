@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3 class="mb-3">Edit Timetable Slot</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </ul>
            </div>
        @endif

        <form action="{{ route('timetables.update', $timetable->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- School --}}
            <div class="mb-3">
                <label class="form-label">School</label>
                <select name="school_id" id="school_id" class="form-select" required>
                    <option value="">Select School</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}"
                            {{ old('school_id', $timetable->school_id) == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Class --}}
            <div class="mb-3">
                <label class="form-label">Class</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" data-school="{{ $class->school_id }}"
                            {{ old('class_id', $timetable->class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} | Section {{ $class->section }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Day --}}
            <div class="mb-3">
                <label class="form-label">Day</label>
                <select name="day" class="form-select" required>
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                        <option value="{{ $day }}" {{ old('day', $timetable->day) == $day ? 'selected' : '' }}>
                            {{ ucfirst($day) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Period --}}
            <div class="mb-3">
                <label class="form-label">Period</label>
                <select name="period_id" id="period_id" class="form-select" required>
                    <option value="">Select Period</option>
                    @foreach ($periods as $period)
                        <option value="{{ $period->id }}"
                            {{ old('period_id', $timetable->period_id) == $period->id ? 'selected' : '' }}>
                            {{ $period->name }} ({{ $period->start_time }} - {{ $period->end_time }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Subject --}}
            <div class="mb-3">
                <label class="form-label">Subject</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">Select Subject</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ old('subject_id', $timetable->subject_id) == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Teacher --}}
            <div class="mb-3">
                <label class="form-label">Teacher</label>
                <select name="teacher_id" id="teacher_id" class="form-select" required>
                    <option value="">Select Teacher</option>
                </select>
            </div>

            <button class="btn btn-success">Update Slot</button>
            <a href="{{ route('timetables.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {

            const currentTeacherId = {{ $timetable->teacher_id }};

            function filterClasses() {
                const schoolId = $('#school_id').val();
                $('#class_id option').each(function() {
                    $(this).toggle($(this).data('school') == schoolId || $(this).val() === '');
                });
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
                    period_id: periodId,
                    timetable_id: {{ $timetable->id }}
                }, function(data) {
                    let html = '<option value="">Select Teacher</option>';
                    $.each(data, function(i, t) {
                        html += `<option value="${t.id}" ${t.id == {{ $timetable->teacher_id }} ? 'selected' : ''}>
            ${t.name} — ${t.specialization}
        </option>`;
                    });
                    $('#teacher_id').html(html);
                });

            }

            // Initial load
            filterClasses();
            fetchTeachers();

            // Events
            $('#school_id').change(filterClasses);
            $('#school_id, #class_id, #subject_id, #period_id, select[name="day"]').change(fetchTeachers);
        });
    </script>
@endsection
