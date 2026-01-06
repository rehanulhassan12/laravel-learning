@extends('layouts.admin')

@section('content')
    {{-- Page Header --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="fw-bold text-primary">Attendance Calendar</h1>
                    <small class="text-muted">View attendance summary by school and class</small>
                </div>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="content">
        <div class="container-fluid">

            {{-- Filters Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body bg-light">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label class="form-label text-primary fw-semibold">School</label>
                            <select id="school-select" class="form-select form-select-sm">
                                <option value="">Select School</option>
                                @foreach ($schools as $school)
                                    <option value="{{ $school->id }}"
                                        {{ ($schoolId ?? '') == $school->id ? 'selected' : '' }}>
                                        {{ $school->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-primary fw-semibold">Class</label>
                            <select id="class-select" class="form-select form-select-sm">
                                <option value="">Select Class</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <button id="filter-btn" class="btn btn-primary btn-sm w-100">Apply Filter</button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Calendar Card --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body bg-light">
                    <div id="calendar"></div>
                </div>
            </div>

        </div>
    </section>

    {{-- FullCalendar & jQuery --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(function() {

            const attendanceData = @json($attendanceData);

            // Convert data to FullCalendar events
            const events = attendanceData.map(d => ({
                title: `P: ${d.present_count} | A: ${d.absent_count}`,
                start: d.date,
                classNames: d.absent_count > 0 ? ['bg-danger', 'text-white'] : ['bg-success',
                    'text-white'
                ]
            }));

            // Initialize calendar
            const calendar = new FullCalendar.Calendar(
                document.getElementById('calendar'), {
                    initialView: 'dayGridMonth',
                    height: 600,
                    events: events,
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek'
                    }
                }
            );
            calendar.render();

            // Initial class load if school selected
            const initialSchool = $('#school-select').val();
            const initialClass = '{{ $classId ?? '' }}';
            if (initialSchool) loadClasses(initialSchool, initialClass);

            // Event handlers
            $('#school-select').on('change', function() {
                loadClasses(this.value);
            });

            $('#filter-btn').on('click', function() {
                let url = '{{ route('dashboard') }}?';
                if ($('#school-select').val()) url += 'school_id=' + $('#school-select').val() + '&';
                if ($('#class-select').val()) url += 'class_id=' + $('#class-select').val();
                window.location.href = url;
            });

            // Load classes dynamically via AJAX
            function loadClasses(schoolId, selected = null) {
                $('#class-select').html('<option>Loading...</option>');

                if (!schoolId) {
                    $('#class-select').html('<option>Select Class</option>');
                    return;
                }

                $.get('{{ route('dashboard.getClasses') }}', {
                    school_id: schoolId
                }, function(data) {
                    let html = '<option value="">Select Class</option>';
                    data.forEach(c => {
                        html +=
                            `<option value="${c.id}" ${selected == c.id ? 'selected' : ''}>${c.label}</option>`;
                    });
                    $('#class-select').html(html);
                });
            }

        });
    </script>
@endsection
