@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>{{ $student->name }} - Monthly Fees</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->studentFees as $fee)
                        <tr>
                            <td>{{ $fee->month }} {{ $fee->year }}</td>
                            <td>{{ $fee->amount }}</td>
                            <td>{{ $fee->is_paid ? 'Paid' : 'Pending' }}</td>
                            <td>
                                @if (!$fee->is_paid)
                                    <form action="{{ route('student_fees.markPaid', $fee->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-success btn-sm">Mark Paid</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
