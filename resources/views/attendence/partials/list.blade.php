@forelse ($attendances as $att)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $att->student->name }}</td>
        <td>{{ $att->student->roll_no }}</td>
        <td class="status-text" data-id="{{ $att->id }}">{{ ucfirst($att->status) }}</td>
        <td>
            <button class="btn btn-primary btn-sm edit-btn" data-id="{{ $att->id }}">Edit</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center text-muted">No records found</td>
    </tr>
@endforelse
