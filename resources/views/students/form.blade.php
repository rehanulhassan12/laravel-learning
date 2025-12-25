@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $student ? 'Edit Student' : 'Add Student' }}</h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ $student ? route('students.update', $student) : route('students.store') }}">
                @csrf
                @if ($student)
                    @method('PUT')
                @endif

                {{-- STUDENT --}}
                <h5>Student</h5>
                <input name="name" class="form-control mb-2" placeholder="Name"
                    value="{{ old('name', $student->name ?? '') }}" required>

                <input name="user_email" class="form-control mb-2" placeholder="Student Email"
                    value="{{ old('user_email', $student->user->email ?? '') }}" required>

                <input name="roll_no" class="form-control mb-2" placeholder="Roll No"
                    value="{{ old('roll_no', $student->roll_no ?? '') }}" required>

                <select name="gender" class="form-control mb-2" required>
                    <option value="male" @selected(old('gender', $student->gender ?? '') == 'male')>Male</option>
                    <option value="female" @selected(old('gender', $student->gender ?? '') == 'female')>Female</option>
                </select>

                <input type="date" name="dob" class="form-control mb-3" value="{{ old('dob', $student->dob ?? '') }}"
                    required>

                {{-- GUARDIAN --}}
                <h5>Guardian</h5>
                <input name="guardian_name" class="form-control mb-2" placeholder="Name"
                    value="{{ old('guardian_name', $student->guardian->name ?? '') }}" required>

                <input name="guardian_email" class="form-control mb-2" placeholder="Email"
                    value="{{ old('guardian_email', $student->guardian->email ?? '') }}" required>

                <input name="guardian_phone" class="form-control mb-2" placeholder="Phone"
                    value="{{ old('guardian_phone', $student->guardian->phone ?? '') }}" required>

                <input name="guardian_relation" class="form-control mb-3" placeholder="Relation"
                    value="{{ old('guardian_relation', $student->guardian->relation ?? '') }}" required>

                {{-- CLASS --}}
                <h5>Class</h5>

                {{-- SCHOOL --}}
                <select id="school_id" class="form-control mb-2">
                    <option value="">Select School</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" @selected(optional(optional($student)->classRoom)->school_id == $school->id)>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>

                {{-- CLASS NAME --}}
                <select id="class_name" class="form-control mb-2">
                    <option value="">Select Class</option>
                </select>

                {{-- SECTION --}}
                <select id="section" class="form-control mb-2">
                    <option value="">Select Section</option>
                </select>

                {{-- SESSION --}}
                <select name="class_id" id="session" class="form-control mb-3" required>
                    <option value="">Select Session</option>
                </select>

                <button class="btn btn-primary">Save</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const classes = @json($classes);

            const schoolSel = document.getElementById('school_id');
            const classSel = document.getElementById('class_name');
            const sectionSel = document.getElementById('section');
            const sessionSel = document.getElementById('session');

            schoolSel.addEventListener('change', () => {
                reset(classSel);
                reset(sectionSel);
                reset(sessionSel);

                const schoolId = schoolSel.value;
                if (!schoolId) return;

                [...new Set(
                    classes.filter(c => c.school_id == schoolId).map(c => c.name)
                )].forEach(name => addOption(classSel, name, name));
            });

            classSel.addEventListener('change', () => {
                reset(sectionSel);
                reset(sessionSel);

                const schoolId = schoolSel.value;
                const className = classSel.value;

                [...new Set(
                    classes.filter(c => c.school_id == schoolId && c.name == className)
                    .map(c => c.section)
                )].forEach(section => addOption(sectionSel, section, section));
            });

            sectionSel.addEventListener('change', () => {
                reset(sessionSel);

                const schoolId = schoolSel.value;
                const className = classSel.value;
                const section = sectionSel.value;

                classes.filter(c =>
                    c.school_id == schoolId &&
                    c.name == className &&
                    c.section == section
                ).forEach(c => {
                    addOption(sessionSel, c.id, c.session_year);
                });
            });

            function reset(select) {
                select.innerHTML = '<option value="">Select</option>';
            }

            function addOption(select, value, text) {
                const opt = document.createElement('option');
                opt.value = value;
                opt.textContent = text;
                select.appendChild(opt);
            }

            {{-- PRELOAD EDIT --}}
            @if ($student && $student->classRoom)
                schoolSel.value = "{{ $student->classRoom->school_id }}";
                schoolSel.dispatchEvent(new Event('change'));

                setTimeout(() => {
                    classSel.value = "{{ $student->classRoom->name }}";
                    classSel.dispatchEvent(new Event('change'));

                    setTimeout(() => {
                        sectionSel.value = "{{ $student->classRoom->section }}";
                        sectionSel.dispatchEvent(new Event('change'));

                        setTimeout(() => {
                            sessionSel.value = "{{ $student->class_id }}";
                        }, 100);
                    }, 100);
                }, 100);
            @endif
        });
    </script>
@endsection
