@extends('layouts.admin')

@section('content')
    <div class="container">

        <div class="card shadow-sm mb-4">
            <div class="card-header py-2">
                <strong>Assign Subjects</strong>
            </div>

            <div class="card-body p-3">
                <form method="GET" action="{{ route('teacher-subjects.index') }}" class="mb-3">
                    <label class="form-label small fw-semibold">Select School</label>
                    <select name="school_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">Select school</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}"
                                {{ $selectedSchool && $selectedSchool->id == $school->id ? 'selected' : '' }}>
                                {{ $school->name }}
                            </option>
                        @endforeach
                    </select>
                </form>

                @if ($selectedSchool)
                    <form method="POST" action="{{ route('teacher-subjects.store') }}">
                        @csrf

                        <!-- Teachers of selected school -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Teacher</label>
                            <select name="teacher_id" class="form-select form-select-sm" required>
                                <option value="">Select teacher</option>
                                @foreach ($teachers as $t)
                                    <option value="{{ $t->id }}">
                                        {{ $t->name }} — {{ $t->specialization }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Subjects -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold">Subjects</label>
                            <div class="row g-2">
                                @foreach ($subjects as $s)
                                    <div class="col-6 col-md-4 col-lg-3">
                                        <div class="form-check border rounded px-2 py-1 small">
                                            <input class="form-check-input" type="checkbox" name="subject_ids[]"
                                                value="{{ $s->id }}" id="sub{{ $s->id }}">
                                            <label class="form-check-label ms-1" for="sub{{ $s->id }}">
                                                {{ $s->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button class="btn btn-sm btn-primary px-4">Assign</button>
                    </form>

                    {{-- Assigned subjects list --}}
                    @foreach ($teachers as $teacher)
                        <div class="card mb-2 mt-2">
                            <div class="card-header py-1 small fw-semibold">
                                {{ $teacher->name }} <span class="text-muted">({{ $teacher->specialization }})</span>
                            </div>
                            <div class="card-body py-2">
                                @forelse($teacher->subjects as $subject)
                                    <span class="badge bg-secondary rounded-pill me-1 mb-1">
                                        {{ $subject->name }}
                                        <form method="POST"
                                            action="{{ route('teacher-subjects.destroy', [$teacher->id, $subject->id]) }}"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-link text-white p-0 ms-1"
                                                style="line-height:1;">×</button>
                                        </form>
                                    </span>
                                @empty
                                    <span class="text-muted small">No subjects assigned</span>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

    </div>
@endsection
