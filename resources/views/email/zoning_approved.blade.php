<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Zoning Application Approved</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">

    <div
        style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
        <h2 style="color: #2c7a7b;">Hello {{ ucwords($application->user->first_name ?? 'Applicant') }},</h2>

        <p style="font-size: 16px; color: #555;">
            We are pleased to inform you that your zoning application has been <strong
                style="color: #2c7a7b;">approved</strong>. Congratulations!
        </p>

        <table style="width: 100%; margin-top: 20px; font-size: 15px; color: #333; border-collapse: collapse;">
            <tr>
                <td style="padding: 8px 0;"><strong>Application No:</strong></td>
                <td>{{ $application->application_no }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Approved At:</strong></td>
                <td>{{ $application->updated_at->format('F j, Y, g:i A') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Status:</strong></td>
                <td style="text-transform: capitalize; color: #2c7a7b;">{{ $application->status }}</td>
            </tr>
        </table>

        <p style="margin-top: 30px; font-size: 15px; color: #555;">
            Please find the attached PDF document containing the full details of your approved application.
        </p>

        <p style="margin-top: 30px; font-size: 15px; color: #555;">
            If you have any questions, feel free to contact our office.
        </p>

        <p style="margin-top: 40px; font-size: 15px; color: #888;">
            — Zoning Department
        </p>
    </div>

</body>

</html>
