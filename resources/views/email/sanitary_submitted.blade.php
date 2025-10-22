<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sanitary Clearance Application Submitted</title>
</head>

<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <tr>
            <td
                style="background:#28a745; color:#fff; padding:15px; text-align:center; font-size:20px; font-weight:bold;">
                Sanitary Clearance Application
            </td>
        </tr>
        <tr>
            <td style="padding:20px; color:#333;">
                <p>Dear <strong>{{ ucwords($application->user->first_name ?? 'Applicant') }}</strong>,</p>

                <p>We have received your <strong>Sanitary / Plumbing Clearance</strong> application for:</p>

                <ul>
                    <li><strong>Application No.:</strong>
                        {{ ucwords($application->application_no ?? 'Applicant') }}</li>
                    <li><strong>Project Location:</strong>
                        {{ ucwords($application->property->property_address ?? 'Applicant') }}</li>
                    <li><strong>Occupancy Type:</strong>
                        {{ ucwords($application->property->occupancy_type ?? 'Applicant') }}</li>
                    <li><strong>Submitted On:</strong>
                        {{ $application->created_at->format('F j, Y, g:i A') }}</li>
                </ul>

                <p>Your application is now under review by the <strong>Sanitary Officer</strong>.
                    You will be notified once your clearance is either <span style="color:green;">approved</span> or
                    <span style="color:red;">returned with remarks</span>.
                </p>

                <p style="margin-top:20px;">Thank you for complying with the health and sanitation requirements of the
                    Local Government Unit.</p>

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
