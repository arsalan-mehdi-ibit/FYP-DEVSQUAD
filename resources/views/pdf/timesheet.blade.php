<!DOCTYPE html>
<html>
<head>
    <title>Timesheets</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: center; }
        th { background-color: #f3f3f3; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Timesheets</h2>
    <table>
        <thead>
            <tr>
                <th>Sr</th>
                <th>Timesheet</th>
                <th>Status</th>
                <th>Total Hours</th>
                <th>Project</th>
                @if (!in_array($role, ['contractor']))
                    <th>Client</th>
                @endif
                @if (!in_array($role, ['client']))
                    <th>Contractor</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($timesheets as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->week_start_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($t->week_end_date)->format('M d, Y') }}</td>
                    <td>{{ strtoupper($t->status) }}</td>
                    <td>{{ $t->total_actual_hours ?? 0 }}</td>
                    <td>{{ $t->project->name ?? 'N/A' }}</td>
                    @if (!in_array($role, ['contractor']))
                        <td>{{ $t->project->client->firstname ?? 'N/A' }}</td>
                    @endif
                    @if (!in_array($role, ['client']))
                        <td>{{ $t->contractor->firstname ?? 'N/A' }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
