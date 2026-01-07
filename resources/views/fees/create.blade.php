@extends('layouts.admin')
@section('content')
    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Add Yearly Fee Form --}}
    <div class="card mb-3">
        <div class="card-header">
            <h3>Set Yearly Fee</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('fees.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label>Class</label>
                        <select name="class_id" class="form-control mb-2" required>
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">
                                    {{ $class->school->name }} - {{ $class->name }} ({{ $class->section }} /
                                    {{ $class->session_year }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Year</label>
                        <input type="number" name="year" class="form-control mb-2" required min="2000"
                            max="{{ date('Y') }}" value="{{ date('Y') }}">
                    </div>

                    <div class="col-md-3">
                        <label>Yearly Amount</label>
                        <input type="number" name="yearly_amount" class="form-control mb-2" required min="0"
                            step="0.01">
                    </div>
                </div>

                <button class="btn btn-primary mt-2">Save</button>
            </form>
        </div>
    </div>

    {{-- List of existing fees with inline edit --}}
    <div class="card">
        <div class="card-header">
            <h3>Existing Yearly Fees</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered" id="feeTable">
                <thead>
                    <tr>
                        <th>School</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Session</th>
                        <th>Year</th>
                        <th>Yearly Amount</th>
                        <th>Monthly Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fees as $fee)
                        <tr>
                            <td>{{ $fee->school->name }}</td>
                            <td>{{ $fee->classRoom->name }}</td>
                            <td>{{ $fee->classRoom->section }}</td>
                            <td>{{ $fee->classRoom->session_year }}</td>
                            <td>{{ $fee->year }}</td>
                            <td>
                                <input type="number" value="{{ $fee->yearly_amount }}" class="form-control yearly-amount"
                                    data-id="{{ $fee->id }}" min="0" step="0.01">
                            </td>
                            <td>{{ $fee->monthly_amount }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Inline update AJAX --}}
    <script>
        document.querySelectorAll('.yearly-amount').forEach(input => {
            input.addEventListener('change', function() {
                const feeId = this.dataset.id;
                const value = this.value;
                fetch('/fees/' + feeId + '/update', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            yearly_amount: value
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            alert('Updated! Monthly amount: ' + data.monthly_amount);
                            location.reload();
                        }
                    });
            });
        });
    </script>
@endsection
