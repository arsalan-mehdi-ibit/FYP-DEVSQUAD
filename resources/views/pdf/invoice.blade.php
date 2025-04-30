<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Invoice - {{ ucfirst($role) }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            text-align: left;
            color: #555;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            font-size: 16px;
            line-height: 24px;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <table>
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="{{ asset('assets/profile.jpeg') }} }}" style="width: 100%; max-width: 300px;" />
                            </td>

                            <td>
                                Invoice #: INV2025-{{ $payment->id }}<br>
                                Created: {{ now()->format('F d, Y') }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            @if ($role === 'contractor')
                                <td>
                                    Contractor: {{ $payment->contractor->firstname }} {{ $payment->contractor->lastname }}<br>
                                    Email: {{ $payment->contractor->email }}
                                </td>
                            @elseif ($role === 'client')
                                <td>
                                    Client: {{ $payment->client->firstname }} {{ $payment->client->lastname }}<br>
                                    Email: {{ $payment->client->email }}
                                </td>
                            @endif

                            <td>
                                Project: {{ $payment->timesheet->project->name }}<br>
                                Week: {{ $payment->timesheet->week_start_date }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Payment Method</td>
                <td>Status</td>
            </tr>

            <tr class="details">
                <td>Bank Transfer</td>
                <td>Paid</td>
            </tr>

            <tr class="heading">
                <td>Description</td>
                <td>Amount</td>
            </tr>

            <tr class="item last">
                <td>Timesheet for {{ $payment->timesheet->week_start_date }}</td>
                <td>
                    @if ($role === 'contractor')
                        ${{ number_format($payment->contractor_paid, 2) }}
                    @elseif ($role === 'client')
                        ${{ number_format($payment->admin_received, 2) }}
                    @endif
                </td>
            </tr>

            <tr class="total">
                <td></td>
                <td>
                    Total:
                    @if ($role === 'contractor')
                        ${{ number_format($payment->contractor_paid, 2) }}
                    @elseif ($role === 'client')
                        ${{ number_format($payment->admin_received, 2) }}
                    @endif
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
