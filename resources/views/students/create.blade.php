@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ isset($student) ? 'Edit' : 'Add' }} Student</h3>
        </div>
        <div class="card-body">
            <form action="{{ isset($student) ? route('students.update', $student) : route('students.store') }}"
                method="POST">
                @csrf
                @if (isset($student))
                    @method('PUT')
                @endif

                <!-- Student Details -->
                <h5>Student Details</h5>
                <label>Name</label>
                <input type="text" name="name" class="form-control mb-2" value="{{ old('name', $student->name ?? '') }}"
                    required>

                <label>User Email</label>
                <input type="email" name="user_email" class="form-control mb-2"
                    value="{{ old('user_email', $student->user->email ?? '') }}" required>

                <label>Roll No</label>
                <input name="roll_no" class="form-control mb-2" value="{{ old('roll_no', $student->roll_no ?? '') }}"
                    required>

                <label>Gender</label>
                <select name="gender" class="form-control mb-2" required>
                    <option value="male" {{ old('gender', $student->gender ?? '') == 'male' ? 'selected' : '' }}>Male
                    </option>
                    <option value="female" {{ old('gender', $student->gender ?? '') == 'female' ? 'selected' : '' }}>Female
                    </option>
                </select>

                <label>DOB</label>
                <input type="date" name="dob" class="form-control mb-2" value="{{ old('dob', $student->dob ?? '') }}"
                    required>

                <hr>

                <!-- Guardian Details -->
                <h5>Guardian Details</h5>
                <label>Name</label>
                <input type="text" name="guardian_name" class="form-control mb-2"
                    value="{{ old('guardian_name', $student->guardian->name ?? '') }}" required>

                <label>Email</label>
                <input type="email" name="guardian_email" class="form-control mb-2"
                    value="{{ old('guardian_email', $student->guardian->email ?? '') }}" required>

                <label>Phone</label>
                <input type="text" name="guardian_phone" class="form-control mb-2"
                    value="{{ old('guardian_phone', $student->guardian->phone ?? '') }}" required>

                <label>Relation</label>
                <input type="text" name="guardian_relation" class="form-control mb-2"
                    value="{{ old('guardian_relation', $student->guardian->relation ?? '') }}" required>

                <label>Address</label>
                <textarea name="guardian_address" class="form-control mb-2">{{ old('guardian_address', $student->guardian->address ?? '') }}</textarea>

                <hr>

                <!-- Class Selection -->
                <h5>Class Selection</h5>
                <label>School</label>
                <select name="school_id" id="school_id" class="form-control mb-2" required>
                    <option value="">-- Select School --</option>
                    @foreach ($schools ?? [] as $school)
                        <option value="{{ $school->id }}"
                            {{ old('school_id', $student->classRoom->school_id ?? '') == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>

                <label>Class Name</label>
                <select name="class_id" id="class_id" class="form-control mb-2" required>
                    <option value="">-- Select Class --</option>
                    @foreach ($classes as $class)
                        @if (old('school_id', $student->classRoom->school_id ?? '') == $class->school_id)
                            <option value="{{ $class->id }}"
                                {{ old('class_id', $student->class_id ?? '') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endif
                    @endforeach
                </select>

                <label>Section</label>
                <input type="text" name="section" class="form-control mb-2"
                    value="{{ old('section', $student->classRoom->section ?? '') }}" readonly>

                <label>Session Year</label>
                <input type="text" name="session_year" class="form-control mb-2"
                    value="{{ old('session_year', $student->classRoom->session_year ?? '') }}" readonly>

                <button class="btn btn-primary">{{ isset($student) ? 'Update' : 'Save' }}</button>
                <a href="{{ route('students.index') }}" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>

    <script>
        // Optional JS to auto-update section/session when class changes
        const classes = @json($classes);
        document.getElementById('class_id').addEventListener('change', function() {
            const classId = parseInt(this.value);
            const selectedClass = classes.find(c => c.id === classId);
            if (selectedClass) {
                document.querySelector('input[name="section"]').value = selectedClass.section ?? '';
                document.querySelector('input[name="session_year"]').value = selectedClass.session_year ?? '';
            } else {
                document.querySelector('input[name="section"]').value = '';
                document.querySelector('input[name="session_year"]').value = '';
            }
        });
    </script>
@endsection
