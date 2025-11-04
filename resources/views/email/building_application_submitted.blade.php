{{-- resources/views/emails/building-application-submitted.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Building Application Submitted</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #1e40af;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .header img {
            max-height: 60px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .content {
            padding: 25px 20px;
            color: #1f2937;
            line-height: 1.7;
            font-size: 16px;
        }

        .content ul {
            padding-left: 20px;
            margin-top: 10px;
        }

        .content li {
            margin-bottom: 6px;
        }

        .button {
            display: inline-block;
            background-color: #1e40af;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 20px;
        }

        .button:hover {
            background-color: #1e3a8a;
        }

        .footer {
            text-align: center;
            color: #6b7280;
            font-size: 12px;
            padding: 20px;
            border-top: 1px solid #e5e7eb;
        }

        @media only screen and (max-width: 640px) {
            .container {
                margin: 20px;
            }

            .header h1 {
                font-size: 20px;
            }

            .content {
                padding: 20px 15px;
                font-size: 15px;
            }

            .button {
                padding: 10px 18px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('asset/icon/logo.png') }}" alt="Municipality Logo">
            <h1>Building Application Submitted</h1>
        </div>
        <div class="content">
            <p>Dear {{ $application->user->first_name }},</p>

            <p>We hereby acknowledge the receipt of your building application. Our office will review your submission,
                and you will be informed of any updates or additional requirements.</p>

            <p><strong>Application Details:</strong></p>
            <ul>
                <li>Application No: <strong>{{ $application->application_no }}</strong></li>
                <li>Status: <strong>{{ ucfirst($application->status) }}</strong></li>
                <li>Type of Application: <strong>{{ $application->type_of_application }}</strong></li>
                <li>Submitted On: <strong>{{ $application->created_at->format('F j, Y, g:i A') }}</strong></li>
            </ul>

            <p>You may monitor your application status at any time by clicking the button below:</p>

            <a href="{{ url('/applicant/building_permit/view_application/' . $application->id) }}" class="button">View
                Application</a>

            <p>Thank you for your cooperation.</p>
            <p>Sincerely,<br>
                <strong>Municipality of Lagonoy</strong>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }}Municipality of Lagonoy. All rights reserved.<br>
            123 Bagong Street, Municipality, Camarines Sur | Phone: (123) 456-7890 | Email: info@municipality.gov
        </div>
    </div>
</body>

</html>
