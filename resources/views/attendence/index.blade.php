@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mark Attendance</h3>
        </div>

        <div class="card-body">

            {{-- Filters --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <label>School</label>
                    <select id="school_id" class="form-control">
                        <option value="">Select School</option>
                        @foreach ($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Class</label>
                    <select id="class_id" class="form-control">
                        <option value="">Select Class</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Session</label>
                    <select id="session" class="form-control">
                        <option value="">Select Session</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Section</label>
                    <select id="section" class="form-control">
                        <option value="">Select Section</option>
                    </select>
                </div>

                <div class="col-md-3 mt-3">
                    <label>Date</label>
                    <input type="date" id="date" class="form-control" value="{{ now()->toDateString() }}">
                </div>
            </div>

            <hr>

            {{-- Students table --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="studentsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Roll No</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-muted">
                                Select filters to load students
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {

            // Load classes
            $('#school_id').on('change', function() {
                console.log($(this).val());
                $.get("{{ route('attendance.students.getClasses') }}", {
                    school_id: $(this).val()
                }, function(data) {
                    let html = '<option value="">Select Class</option>';
                    data.forEach(c => html += `<option value="${c.id}">${c.name}</option>`);
                    $('#class_id').html(html);
                });
            });

            // Load sessions
            $('#class_id').on('change', function() {
                $.get("{{ route('attendance.students.getSessions') }}", {
                    class_id: $(this).val()
                }, function(data) {
                    let html = '<option value="">Select Session</option>';
                    data.forEach(s => html += `<option value="${s}">${s}</option>`);
                    $('#session').html(html);
                });
            });

            // Load sections
            $('#session').on('change', function() {
                $.get("{{ route('attendance.students.getSections') }}", {
                    class_id: $('#class_id').val(),
                    session: $(this).val()
                }, function(data) {
                    let html = '<option value="">Select Section</option>';
                    data.forEach(sec => html += `<option value="${sec}">${sec}</option>`);
                    $('#section').html(html);
                });
            });

            // Load students
            $('#section, #date').on('change', loadStudents);

            function loadStudents() {
                $.post("{{ route('attendance.student') }}", {
                    _token: "{{ csrf_token() }}",
                    school_id: $('#school_id').val(), // ✅ add this
                    class_id: $('#class_id').val(),
                    session: $('#session').val(),
                    section: $('#section').val(),
                    date: $('#date').val()
                }, function(html) {
                    $('#studentsTable tbody').html(html);
                });
            }
            $(document).on('click', '.mark-btn', function() {
                let row = $(this).closest('tr');
                let studentId = $(this).data('student');
                let classId = $(this).data('class');
                let status = $(this).data('status');
                let date = $('#date').val();

                $.post("{{ route('attendance.students.store') }}", {
                    _token: "{{ csrf_token() }}",
                    student_id: studentId,
                    class_id: classId,
                    status: status,
                    date: date
                }, function(res) {
                    if (res.success) {
                        row.remove(); // ✅ only remove the marked row
                    }
                });
            });


        });
    </script>
@endpush
