<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Rescheduled Onsite Visitation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px;">

    <div
        style="max-width: 650px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.05);">

        <!-- Header -->
        <h2 style="color: #e67e22; margin-bottom: 10px;">Onsite Visitation Rescheduled</h2>
        <p style="color: #555; font-size: 15px; margin-top: 0;">
            Hello {{ ucwords($application->user->first_name ?? 'Applicant') }},
        </p>

        <!-- Message -->
        <p style="font-size: 15px; color: #555;">
            Please be advised that your onsite visitation for your zoning application has been
            <strong>rescheduled</strong>. Below are your updated visitation details:
        </p>

        <!-- Details -->
        <table style="width: 100%; margin: 20px 0; border-collapse: collapse; font-size: 15px; color: #333;">
            <tr>
                <td style="padding: 8px 0; width: 40%;"><strong>Application No:</strong></td>
                <td>{{ $application->application_no }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>New Visit Date:</strong></td>
                <td>{{ \Carbon\Carbon::parse($application->visitation->visit_date)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>New Visit Time:</strong></td>
                <td>{{ \Carbon\Carbon::parse($application->visitation->visit_time)->format('g:i A') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Status:</strong></td>
                <td style="text-transform: capitalize;">{{ $application->visitation_status ?? 'Rescheduled' }}</td>
            </tr>
        </table>

        <!-- Instructions -->
        <p style="margin-top: 20px; font-size: 15px; color: #555;">
            Please adjust your availability accordingly and ensure that you or your authorized representative will be
            present at the new schedule.
        </p>

        <!-- Closing -->
        <p style="margin-top: 40px; font-size: 15px; color: #888;">
            — Zoning Department
        </p>
    </div>

</body>

</html>
