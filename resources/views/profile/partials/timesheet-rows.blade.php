{{-- resources/views/partials/timesheet-rows.blade.php --}}

@foreach($timesheets as $timesheet)
    <tr>
        <td>{{ $timesheet->id }}</td>
        <td>
            {{ \Carbon\Carbon::parse($timesheet->week_start_date)->format('M d, Y') }}
            -
            {{ \Carbon\Carbon::parse($timesheet->week_end_date)->format('M d, Y') }}
        </td>
        <td>{{ ucfirst($timesheet->status) }}</td>
        <td>{{ $timesheet->project->name ?? '-' }}</td>
        <td>{{ $timesheet->contractor->firstname ?? '-' }}</td>
        <td>{{ $timesheet->project->client->firstname ?? '-' }}</td>
    </tr>
@endforeach
