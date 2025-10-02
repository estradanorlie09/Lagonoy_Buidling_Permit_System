<!DOCTYPE html>
<html>

<head>
    <title>Zoning Certification</title>
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
            /* Adjust fade here (0.1 = very light, 0.3 = darker) */
            z-index: -1;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            width: 80px;
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

        .small {
            font-size: 11px;
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
        <img src="{{ public_path('asset/icon/logo.png') }}" alt="Seal" width="80">

        <h3>Republic of the Philippines</h3>
        <h3>Province of Camarines Sur</h3>
        <h2><strong>MUNICIPALITY OF Lagonoy</strong></h2>
        <h3>ZONING ADMINISTRATION</h3>
        <h3><u>ZONING CERTIFICATION</u></h3>
        <p>No. <span class="app_no">{{ $application->application_no }}</span></p>
    </div>

    <!-- Body -->
    <p>
        This is to certify that the land situated at
        <strong>{{ $application->property->property_address }}</strong>,
        municipality of Lagonoy, covering
        <strong>{{ $application->property->lot_area }}</strong> square meters,
        described as follows:
    </p>

    <table>
        <thead>
            <tr>
                <th>Registered Owner</th>
                <th>OCT/TCT No.</th>
                <th>Area per Title (sq.m)</th>
                <th>Zoning Classification</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ ucwords($application->user->first_name) }} {{ ucwords($application->user->last_name) }}</td>
                <td>{{ $application->property->tax_declaration }}</td>
                <td>{{ $application->property->lot_area }}</td>
                <td>As per Zoning Ordinance No. ___</td>
            </tr>
        </tbody>
    </table>

    <div class="conditions">
        <p><strong>Conditions:</strong></p>
        <p>(x) This certification shall not be considered as a locational clearance/certificate of zoning
            conformance or
            development permit.</p>
        <p>(x) This certification shall not be considered as a certification of the HLURB as to the ownership of the
            parcel of land subject of this certification.</p>
        <p>(x) Any misrepresentation or material falsehood on the part of the applicant shall be sufficient cause
            for
            the cancellation of this permit.</p>
        <p>( ) Others: ____________________</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>ZC No. _______ &nbsp;&nbsp;&nbsp;&nbsp; OR No. _______</p>
        <p>Date: __________ &nbsp;&nbsp;&nbsp;&nbsp; Amount Paid: __________</p>
    </div>

    <!-- Signature -->
    <div class="signature">
        <p><strong>{{ ucwords($application->approver?->first_name) }}
                {{ ucwords($application->approver?->middle_name) }}
                {{ ucwords($application->approver?->lastname) }}</strong><br>
            Zoning Administrator</p>

    </div>
    <p>{{ $application->id }}</p>


    <p>
        <img src="{{ $qrCodeUrl }}" alt="QR Code">
        <br>
        Scan to Verify
    </p>
</body>

</html>
