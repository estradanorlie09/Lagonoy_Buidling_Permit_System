<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Cancelled Onsite Visitation</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f6f8; padding: 20px;">

    <div
        style="max-width: 650px; margin: auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.05);">

        <!-- Header -->
        <h2 style="color: #c0392b; margin-bottom: 10px;">Onsite Visitation Cancelled</h2>
        <p style="color: #555; font-size: 15px; margin-top: 0;">
            Hello {{ ucwords($application->user->first_name ?? 'Applicant') }},
        </p>

        <!-- Message -->
        <p style="font-size: 15px; color: #555;">
            We regret to inform you that your scheduled onsite visitation has been <strong>cancelled</strong>. Below are
            the details of the cancelled visitation:
        </p>

        <!-- Details -->
        <table style="width: 100%; margin: 20px 0; border-collapse: collapse; font-size: 15px; color: #333;">
            <tr>
                <td style="padding: 8px 0; width: 40%;"><strong>Application No:</strong></td>
                <td>{{ $application->application_no }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Original Visit Date:</strong></td>
                <td>{{ \Carbon\Carbon::parse($visitation->visit_date)->format('F j, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0;"><strong>Original Visit Time:</strong></td>
                <td>{{ \Carbon\Carbon::parse($visitation->visit_time)->format('g:i A') }}</td>
            </tr>

            <tr>
                <td style="padding: 8px 0;"><strong>Status:</strong></td>
                <td style="text-transform: capitalize;">Cancelled</td>
            </tr>
        </table>

        <!-- Instructions -->
        <p style="margin-top: 20px; font-size: 15px; color: #555;">
            You will be notified once a new schedule is arranged. We apologize for the inconvenience.
        </p>

        <!-- Closing -->
        <p style="margin-top: 40px; font-size: 15px; color: #888;">
            — Zoning Department
        </p>
    </div>

</body>

</html>
