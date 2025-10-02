<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Certificate Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 30px;
            text-align: center;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: inline-block;
            max-width: 600px;
            width: 100%;
        }

        .valid {
            color: green;
            font-size: 22px;
            font-weight: bold;
        }

        .invalid {
            color: red;
            font-size: 22px;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>🏛 Municipality of Lagonoy</h2>
        <h3>Zoning Certification Verification</h3>

        @if ($application)
            <p class="valid">✅ This certificate is VALID</p>
            <table>
                <tr>
                    <th>Certificate No.</th>
                    <td>{{ $application->application_no }}</td>
                </tr>
                <tr>
                    <th>Owner</th>
                    <td>{{ ucwords($application->user->first_name) }} {{ ucwords($application->user->last_name) }}</td>
                </tr>
                <tr>
                    <th>Property Address</th>
                    <td>{{ $application->property->property_address }}</td>
                </tr>
                <tr>
                    <th>Lot Area</th>
                    <td>{{ $application->property->lot_area }} sq.m</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ ucfirst($application->status) }}</td>
                </tr>
            </table>
        @else
            <p class="invalid">❌ This certificate could not be verified.</p>
        @endif
    </div>
</body>

</html>
