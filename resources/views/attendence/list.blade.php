@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Attendance Records</h3>
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
                    <input type="date" id="date" class="form-control">
                </div>
            </div>

            <hr>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-bordered" id="attendanceTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student</th>
                            <th>Roll No</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center text-muted">Select filters to load records</td>
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
            // Load classes, sessions, sections (similar to index)
            $('#school_id').on('change', function() {
                $.get("{{ route('attendance.students.getClasses') }}", {
                    school_id: $(this).val()
                }, function(data) {
                    let html = '<option value="">Select Class</option>';
                    data.forEach(c => html += `<option value="${c.id}">${c.name}</option>`);
                    $('#class_id').html(html);
                });
            });
            $('#class_id').on('change', function() {
                $.get("{{ route('attendance.students.getSessions') }}", {
                    class_id: $(this).val()
                }, function(data) {
                    let html = '<option value="">Select Session</option>';
                    data.forEach(s => html += `<option value="${s}">${s}</option>`);
                    $('#session').html(html);
                });
            });
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

            // Load attendance records
            $('#section, #date').on('change', loadAttendance);

            function loadAttendance() {
                $.post("{{ route('attendance.list.data') }}", {
                    _token: "{{ csrf_token() }}",
                    school_id: $('#school_id').val(),
                    class_id: $('#class_id').val(),
                    session: $('#session').val(),
                    section: $('#section').val(),
                    date: $('#date').val()
                }, function(html) {
                    $('#attendanceTable tbody').html(html);
                });
            }

            // Edit attendance
            $(document).on('click', '.edit-btn', function() {
                let btn = $(this);
                let row = btn.closest('tr');
                let statusCell = row.find('.status-text');
                let id = btn.data('id');

                if (btn.text() === 'Edit') {
                    // Change to dropdown
                    let currentStatus = statusCell.text().toLowerCase();
                    statusCell.html(`
            <select class="form-control status-select">
                <option value="present" ${currentStatus==='present'?'selected':''}>Present</option>
                <option value="absent" ${currentStatus==='absent'?'selected':''}>Absent</option>
            </select>
        `);
                    btn.text('Save');
                } else {
                    // Save new status
                    let newStatus = statusCell.find('select').val();
                    $.post("{{ route('attendance.update') }}", {
                        _token: "{{ csrf_token() }}",
                        attendance_id: id,
                        status: newStatus
                    }, function(res) {
                        if (res.success) {
                            statusCell.text(newStatus.charAt(0).toUpperCase() + newStatus.slice(1));
                            btn.text('Edit');
                        }
                    });
                }
            });

        });
    </script>
@endpush
