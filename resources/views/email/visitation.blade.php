<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Onsite Visitation Schedule</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px;">

    <div
        style="max-width: 650px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.05);">

        <!-- Header -->
        <h2 style="color: #2c3e50; margin-bottom: 10px;">Onsite Visitation Notice</h2>
        <p style="color: #555; font-size: 15px; margin-top: 0;">
            Hello {{ ucwords($application->user->first_name ?? 'Applicant') }},
        </p>

        <!-- Intro -->
        <p style="font-size: 15px; color: #555;">
            This is to inform you that an <strong>onsite visitation</strong> has been scheduled for your zoning
            application. Please review the details below:
        </p>

        <!-- Details Table -->
        <table style="width: 100%; margin: 20px 0; border-collapse: collapse; font-size: 15px; color: #333;">
            <tr>
                <td style="padding: 8px 0; width: 40%;"><strong>Application No:</strong></td>
                <td>{{ $application->application_no }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Visit Date:</strong></td>
                <td>{{ \Carbon\Carbon::parse($application->visitation->visit_date)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Visit Time:</strong></td>
                <td>{{ \Carbon\Carbon::parse($application->visitation->visit_time)->format('g:i A') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Status:</strong></td>
                <td style="text-transform: capitalize;">{{ $application->visitation_status ?? 'Scheduled' }}</td>
            </tr>
        </table>

        <!-- Instructions -->
        <p style="margin-top: 20px; font-size: 15px; color: #555;">
            Kindly ensure that you or your authorized representative is present at the given date and time.
            Please prepare all necessary documents for inspection.
        </p>

        <!-- Closing -->
        <p style="margin-top: 30px; font-size: 15px; color: #555;">
            If you have any questions, please contact our office prior to your visitation.
        </p>

        <p style="margin-top: 40px; font-size: 15px; color: #888;">
            — Zoning Department
        </p>
    </div>

</body>

</html>
