@forelse ($students as $student)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $student->name }}</td>
        <td>{{ $student->roll_no }}</td>
        <td>
            <button class="btn btn-success btn-sm mark-btn" data-student="{{ $student->id }}"
                data-class="{{ $student->class_id }}" data-status="present">Present</button>
            <button class="btn btn-danger btn-sm mark-btn" data-student="{{ $student->id }}"
                data-class="{{ $student->class_id }}" data-status="absent">Absent</button>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="4" class="text-center text-muted">No students to mark</td>
    </tr>
@endforelse
