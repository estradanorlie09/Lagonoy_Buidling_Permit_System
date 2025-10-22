<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Sanitary Clearance Application Requires Resubmission</title>
</head>

<body style="font-family: Arial, sans-serif; background-color:#f9f9f9; padding:20px;">

    <table width="100%" cellpadding="0" cellspacing="0"
        style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 6px rgba(0,0,0,0.1);">
        <tr>
            <td
                style="background:#ffc107; color:#fff; padding:15px; text-align:center; font-size:20px; font-weight:bold;">
                Sanitary Clearance Application Requires Resubmission
            </td>
        </tr>
        <tr>
            <td style="padding:20px; color:#333;">
                <p>Dear <strong>{{ ucwords($application->user->first_name ?? 'Applicant') }}</strong>,</p>

                <p>After review, your <strong>Sanitary / Plumbing Clearance</strong> application requires
                    <span style="color:#ff9800; font-weight:bold;">RESUBMISSION</span> with corrections or additional
                    documents.
                </p>

                <ul>
                    <li><strong>Application No.:</strong> {{ $application->application_no }}</li>
                    <li><strong>Project Location:</strong> {{ $application->property->property_address }}</li>
                    <li><strong>Occupancy Type:</strong> {{ $application->property->occupancy_type }}</li>
                    <li><strong>Reviewed On:</strong> {{ now()->format('F j, Y, g:i A') }}</li>
                </ul>

                @if (isset($currentRemarks) && $currentRemarks->isNotEmpty())
                    <p><strong>Remarks:</strong></p>
                    <ul>
                        @foreach ($currentRemarks as $remark)
                            <li>{{ $remark->remark }}</li>
                        @endforeach
                    </ul>
                @endif

                <p>Please review the remarks and resubmit your application through the system.</p>

                <p style="margin-top:20px;">We appreciate your prompt attention to this matter.</p>

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
