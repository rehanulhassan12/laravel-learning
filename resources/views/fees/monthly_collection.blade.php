@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3 class="mb-3">Monthly Fee Collection</h3>

        {{-- Filters --}}
        <form method="GET" class="row mb-4">

            {{-- School --}}
            <div class="col-md-3">
                <label>School</label>
                <select name="school_id" id="school" class="form-control">
                    <option value="">Select School</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ $school_id == $school->id ? 'selected' : '' }}>
                            {{ $school->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Class --}}
            <div class="col-md-4">
                <label>Class (Section | Session)</label>
                <select name="class_id" id="class" class="form-control">
                    <option value="">Select Class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->id }}" data-school="{{ $class->school_id }}"
                            {{ $class_id == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} | {{ $class->section }} | {{ $class->session_year }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Month --}}
            <div class="col-md-3">
                <label>Month</label>
                <select name="month" class="form-control">
                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ $m }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Year --}}
            <div class="col-md-2">
                <label>Year</label>
                <input type="number" name="year" class="form-control" value="{{ $year }}">
            </div>

            <div class="col-md-12 mt-3">
                <button class="btn btn-primary">Filter</button>
            </div>
        </form>

        {{-- Fees Table --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>School</th>
                    <th>Class</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fees as $fee)
                    <tr id="fee-{{ $fee->id }}">
                        <td>{{ $fee->student->name }}</td>
                        <td>{{ $fee->student->classRoom->school->name }}</td>
                        <td>
                            {{ $fee->student->classRoom->name }}
                            ({{ $fee->student->classRoom->section }}
                            | {{ $fee->student->classRoom->session_year }})
                        </td>
                        <td>{{ $fee->month }}</td>
                        <td>{{ $fee->year }}</td>
                        <td>
                            <input type="number" class="form-control amount" data-id="{{ $fee->id }}"
                                value="{{ $fee->amount }}">
                        </td>
                        <td>
                            <button class="btn btn-success btn-pay" data-id="{{ $fee->id }}">
                                Mark Paid
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No unpaid fees found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- JS --}}
    <script>
        const schoolSelect = document.getElementById('school');
        const classSelect = document.getElementById('class');

        function filterClasses() {
            const schoolId = schoolSelect.value;

            [...classSelect.options].forEach(option => {
                if (!option.value) return;

                option.style.display =
                    option.dataset.school === schoolId || schoolId === '' ?
                    'block' :
                    'none';
            });

            classSelect.value = '';
        }

        schoolSelect.addEventListener('change', filterClasses);
        document.addEventListener('DOMContentLoaded', filterClasses);

        // Mark Paid
        document.querySelectorAll('.btn-pay').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const amount = document.querySelector('.amount[data-id="' + id + '"]').value;

                if (!confirm('Confirm payment?')) return;

                fetch('/fees/monthly/' + id + '/paid', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            amount
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById('fee-' + id).remove();
                            alert(data.message);
                        }
                    });
            });
        });
    </script>
@endsection
