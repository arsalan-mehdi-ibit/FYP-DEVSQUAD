<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Timesheet Submission Reminder</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 30px;
        }

        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            color: #2f3640;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .content {
            font-size: 15px;
            color: #333;
            line-height: 1.6;
        }

        .details {
            margin: 20px 0;
            padding: 15px;
            background: #f1f2f6;
            border-radius: 5px;
        }

        .details strong {
            display: inline-block;
            width: 160px;
            color: #2f3640;
        }

        .footer {
            font-size: 13px;
            color: #888;
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>

<body>
    {{-- @php
        $fullContractor = \App\Models\ProjectContractor::find($contractor['contractor_id']);
    @endphp --}}

    <div class="container">
        <div class="header">Timesheet Submission Reminder</div>

        <div class="content">
            <p>Dear {{ $timesheet->contractor->firstname }} {{ $timesheet->contractor->lastname }},</p>

            <p>You still haven’t submitted your timesheet for the week ending on
                <strong>{{ \Carbon\Carbon::parse($timesheet->week_end)->toFormattedDateString() }}</strong>.
            </p>

            <div class="details">
                <p><strong>Project Name:</strong> {{ $project_name }}</p>
                <p><strong>Timesheet Name:</strong>
                    {{ \Carbon\Carbon::parse($timesheet->week_start_date)->format('M d, Y') }} -
                    {{ \Carbon\Carbon::parse($timesheet->week_end_date)->format('M d, Y') }}</p>

                {{-- <p><strong>Week Ending:</strong>
                    {{ \Carbon\Carbon::parse($timesheet->week_end)->toFormattedDateString() }}</p> --}}
                <p><strong>Status:</strong> Not Submitted</p>
            </div>

            <p>Please submit it as soon as possible</p>
        </div>

        <div class="footer">
            Regards,<br>
            TrackPoint <br><br>
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>

</html>
