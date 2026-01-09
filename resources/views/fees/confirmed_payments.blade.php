@extends('layouts.admin')

@section('content')
    <div class="container">
        <h3 class="mb-3">Confirmed Payments</h3>

        {{-- Filters --}}
        <form method="GET" class="row mb-4">

            {{-- School --}}
            <div class="col-md-3">
                <label>School</label>
                <select name="school_id" id="school" class="form-control">
                    <option value="">Select School</option>
                    @foreach ($schools as $school)
                        <option value="{{ $school->id }}" {{ request('school_id') == $school->id ? 'selected' : '' }}>
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
                            {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }} | {{ $class->section }} | {{ $class->session_year }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Month --}}
            <div class="col-md-3">
                <label>Month</label>
                <select name="month" class="form-control">
                    <option value="">All Months</option>
                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $m)
                        <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                            {{ $m }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Year --}}
            <div class="col-md-2">
                <label>Year</label>
                <input type="number" name="year" class="form-control" value="{{ request('year') }}">
            </div>

            <div class="col-md-12 mt-3">
                <button class="btn btn-primary">Filter</button>
            </div>
        </form>

        {{-- Payments Table --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>School</th>
                    <th>Class</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Amount</th>
                    <th>Paid At</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payments as $p)
                    <tr>
                        <td>{{ $p->student->name }}</td>
                        <td>{{ $p->student->classRoom->school->name }}</td>
                        <td>
                            {{ $p->student->classRoom->name }}
                            ({{ $p->student->classRoom->section }}
                            | {{ $p->student->classRoom->session_year }})
                        </td>
                        <td>{{ $p->month }}</td>
                        <td>{{ $p->year }}</td>
                        <td>{{ $p->amount }}</td>
                        <td>{{ $p->paid_at }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            No confirmed payments found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- JS: School → Class --}}
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
    </script>
@endsection
