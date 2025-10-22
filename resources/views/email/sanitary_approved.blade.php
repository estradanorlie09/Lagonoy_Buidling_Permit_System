<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sanitary Clearance Application Approved</title>
</head>

<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <tr>
            <td
                style="background:#28a745; color:#fff; padding:15px; text-align:center; font-size:20px; font-weight:bold;">
                Sanitary Clearance Application Approved
            </td>
        </tr>
        <tr>
            <td style="padding:20px; color:#333;">
                <p>Dear <strong>{{ ucwords($application->user->first_name ?? 'Applicant') }}</strong>,</p>

                <p>Congratulations! Your <strong>Sanitary / Plumbing Clearance</strong> application has been
                    <span style="color:green; font-weight:bold;">APPROVED</span>.
                </p>

                <ul>
                    <li><strong>Application No.:</strong> {{ $application->application_no }}</li>
                    <li><strong>Project Location:</strong> {{ $application->property->property_address }}</li>
                    <li><strong>Occupancy Type:</strong> {{ $application->property->occupancy_type }}</li>
                    <li><strong>Approved On:</strong> {{ now()->format('F j, Y, g:i A') }}</li>
                </ul>

                <p>Please visit the office to claim your approved clearance or check your applicant portal for the
                    downloadable copy (if available).</p>

                <p style="margin-top:20px;">Thank you for complying with the sanitation requirements of the Local
                    Government Unit.</p>

                <p>Respectfully,<br>
                    <strong>Sanitary & Plumbing Officer</strong><br>
                    -- LGU
                </p>
            </td>
        </tr>
        <tr>
            <td style="background:#f1f1f1; padding:10px; text-align:center; font-size:12px; color:#777;">
                This is an automated email. Please do not reply directly.
            </td>
        </tr>
    </table>

</body>

</html>
