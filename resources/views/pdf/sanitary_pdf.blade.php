<!DOCTYPE html>
<html>

<head>
    <title>Sanitary/Plumbing Permit</title>
    <style>
        @page {
            margin: 40px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            position: relative;
            z-index: 1;
        }

        /* Watermark background */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ public_path('asset/icon/logo.png') }}") no-repeat center center;
            background-size: cover;
            opacity: 0.1;
            z-index: -1;
        }

        .header {
            position: relative;
            /* QR stays inside header */
            text-align: center;
            margin-bottom: 20px;
        }

        /* QR Code styling */
        .header .qr {
            position: absolute;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .header .qr img {
            width: 60px;
            height: 60px;
            margin-bottom: 2px;
        }

        .header .qr p {
            font-size: 9px;
            margin: 0;
        }

        /* Seal/Logo styling */
        .header .seal {
            width: 60px;
            height: auto;
            margin-bottom: 5px;
        }

        h2,
        h3 {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }

        .conditions {
            margin-top: 20px;
        }

        .footer {
            margin-top: 40px;
        }

        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .app_no {
            text-decoration: underline;
            color: red;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <!-- QR fixed inside header, top-left -->
        <div class="qr">
            <img src="{{ $qrCodeUrl }}" alt="QR Code">
            <p>Scan to Verify</p>
        </div>

        <!-- Centered header text -->
        <img class="seal" src="{{ public_path('asset/icon/logo.png') }}" alt="Seal">
        <h3>Republic of the Philippines</h3>
        <h3>Province of Camarines Sur</h3>
        <h2><strong>Municipality of Lagonoy</strong></h2>
        <h3>Office of the Municipal Sanitary Engineer</h3>
        <h3><u>SANITARY / PLUMBING PERMIT</u></h3>
        <p>No. <span class="app_no">{{ $application->application_no }}</span></p>
    </div>

    <!-- Body -->
    <div class="permit-body">
        <p>
            Pursuant to the provisions of the <strong>National Plumbing Code of the Philippines</strong> and applicable
            sanitary laws, permission is hereby granted to
            <strong>{{ ucwords($application->user->first_name) }} {{ ucwords($application->user->last_name) }}</strong>
            (Owner/Applicant),
            to commence with the installation and execution of sanitary and plumbing works for the project located at
            <strong>{{ $application->property->property_address }}</strong>.
        </p>

        <table>
            <thead>
                <tr>
                    <th>Owner/Applicant</th>
                    <th>Project Location</th>
                    <th>Type of Occupancy</th>
                    <th>Permit Number</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>____________________________</td>
                    <td>____________________________</td>
                    <td>____________________________</td>
                    <td>____________________________</td>
                </tr>
            </tbody>
        </table>

        <div class="conditions">
            <p><strong>Conditions:</strong></p>
            <p>(x) This permit is valid only for sanitary and plumbing works described in the approved plans.</p>
            <p>(x) No deviation shall be made without prior approval of the Municipal Sanitary Engineer.</p>
            <p>(x) This permit does not exempt the applicant from securing other permits required by law.</p>
            <p>( ) Others: _______________________________</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Permit No.: _______ &nbsp;&nbsp;&nbsp; OR No.: _______</p>
        <p>Date Issued: __________ &nbsp;&nbsp;&nbsp; Amount Paid: __________</p>
    </div>

    <!-- Signature -->
    <div class="signature">
        <p><strong>____________________________</strong><br>
            Municipal Sanitary Engineer / Plumbing Official</p>
    </div>
</body>

</html>
