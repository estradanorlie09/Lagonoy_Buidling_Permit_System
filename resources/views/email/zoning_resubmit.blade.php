<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zoning Application Requires Resubmission</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">

    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">

        <h2 style="color: #333;">Hello {{ ucwords($application->user->first_name ?? 'Applicant') }},</h2>

        <p style="font-size: 16px; color: #555;">
            After reviewing your zoning application, we found that <strong>corrections or additional information are
                needed</strong>.
            Please resubmit your application with the necessary updates.
        </p>

        <table style="width: 100%; margin-top: 20px; font-size: 15px; color: #333; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0;"><strong>Application No:</strong></td>
                <td>{{ $application->application_no }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Reviewed At:</strong></td>
                <td>{{ now()->format('F j, Y, g:i A') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Status:</strong></td>
                <td style="color: orange; text-transform: capitalize;">{{ $application->status }}</td>
            </tr>

            @if ($currentRemarks->isNotEmpty())
                <tr>
                    <td style="padding: 8px 0; vertical-align: top;"><strong>Remarks:</strong></td>
                    <td>
                        <ul style="margin: 0; padding-left: 18px; color: #555;">
                            @foreach ($currentRemarks as $remark)
                                <p>{{ $remark->remark }}
                                    <small style="color: #888;">—
                                        {{ $remark->officer->first_name ?? 'Officer' }}</small>
                                <p>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endif
        </table>

        <p style="margin-top: 30px; font-size: 15px; color: #555;">
            Kindly review the remarks above and provide the required documents or corrections, then resubmit your
            application through the system.
        </p>

        <p style="margin-top: 40px; font-size: 15px; color: #888;">
            — Zoning Department
        </p>
    </div>

</body>

</html>
