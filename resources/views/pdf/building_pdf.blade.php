<!DOCTYPE html>
<html lang="en">

<head>
    <title>Building Permit</title>
    <style>
        /* Reset & Base */
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Times New Roman", Times, serif;
            background: url("{{ public_path('asset/bg/building-bg.png') }}") no-repeat center center fixed;
            background-size: cover;
            color: #000;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url("{{ public_path('asset/icon/logo.png') }}") no-repeat center center;
            background-size: cover;
            opacity: 0.1;
            z-index: -1;

        }

        .container {
            width: 95%;
            height: 91.4%;
            border: 5px double #003366;
            margin: 1.5rem auto;
            padding-bottom: 2rem;
            position: relative;


        }

        /* Header Text */
        h6 {
            text-align: center;
            font-size: 0.95rem;
            font-weight: normal;
            letter-spacing: 0.5px;
        }

        h4 {
            text-align: center;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 0.3rem 0;
            letter-spacing: 0.5px;
        }

        h1 {
            text-align: center;
            font-size: 2rem;
            font-family: "Georgia", "Times New Roman", serif;
            margin-top: 0.5rem;
            letter-spacing: 2px;
            text-decoration: underline;
        }

        /* Header Layout */
        .header {
            padding: 1.5rem 1rem;
            position: relative;
        }

        /* QR Code & Logo */
        .qr_code,
        .logo {
            position: absolute;
            top: 1.5rem;
        }

        .qr_code {
            left: 1.5rem;
        }

        .logo {
            right: 1.5rem;
        }

        .qr_code img,
        .logo img {
            width: 5rem;
            height: 5rem;
        }

        .divider {
            width: 80%;
            height: 1px;
            background: #003366;
            margin: 0.8rem auto;
        }

        .wrapper-1 {
            display: flex;
            margin: 1rem 0 0 13.5rem;
        }

        input[type="checkbox"] {
            width: 1rem;
            height: 1rem;
            color: rgb(12, 12, 44);
        }

        .subhead {
            width: 100%;
            margin-top: 1rem;
        }

        .left-subhead,
        .right-subhead {
            display: inline-block;
            vertical-align: top;
            width: 48%;

        }

        .left-subhead div,
        .right-subhead div {
            margin-bottom: 0.4rem;
            margin-left: 4rem;
            font-size: 14px;
        }

        .text-content {
            margin: 2rem;
            padding: 0.5rem;
            line-height: 24px;
        }

        .details {
            margin: 3rem 0 0 5rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="qr_code">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($qrCodeUrl)) }}" alt="QR Code">
            </div>

            <div class="logo">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('asset/icon/logo.png'))) }}"
                    alt="LGU LOGO">
            </div>

            <h6>Republic of the Philippines</h6>
            <h6>City/Municipality of Lagonoy</h6>
            <h4>OFFICE OF THE BUILDING OFFICIAL</h4>
            <div class="divider"></div>
            <h1>BUILDING PERMIT</h1>
            <div class="wrapper-1">
                <input type="checkbox" {{ $application->type_of_application == 'new' ? 'checked' : '' }}>
                <span>NEW</span>
                <input type="checkbox" {{ $application->type_of_application == 'renewal' ? 'checked' : '' }}>
                <span>RENEWAL</span>
                <input type="checkbox" {{ $application->type_of_application == 'amendatory' ? 'checked' : '' }}>
                <span>AMENDATORY</span>

            </div>
        </div>

        <div class="subhead">
            <div class="left-subhead">
                <div>
                    <label for="building_permit_no">BUILDING PERMIT NO. : <span style="text-decoration: underline;">
                            {{ $application->building_permit_no }}</span></label>
                </div>
                <div>
                    <label for="date_issued">DATE ISSUED : <span
                            style="text-decoration:underline">{{ $application->issued_date }}</span></label>
                </div>
                <div>
                    <label for="Fsec_no">FSEC NO : <span
                            style="text-decoration:underline">{{ $application->property->fsec_no }}</span></label>
                </div>
                <div>
                    <label for="date_issued">DATE ISSUED : <span style="text-decoration:underline">
                            {{ $application->property->fsec_issued_date }}</span>
                    </label>
                </div>
            </div>

            <div class="right-subhead">
                <div>
                    <label for="or">OFFICIAL RECIEPT NO. : <span
                            style="text-decoration:underline">923453123</span></label>
                </div>
                <div>
                    <label for="date_paid">DATE PAID : <span style="text-decoration:underline">2025-11-05</span></label>
                </div>

            </div>
        </div>

        <div class="text-content">
            <p>&nbsp;&nbsp;This <strong>PERMIT</strong> is issued pursuant to sections 207, 301, 302, 303 and 304 of the
                National
                Building Code of the Philippines (PD 1096), its Revised IRR, other Referal Codes and its Terms and
                Conditions.</p>
        </div>

        <div class="details">
            <div style="padding: 1rem;">
                <label for="Owner"> Owner / Permittee
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                    <span style="margin-left: 0.8rem; text-decoration: underline;">{{ $application->user->first_name }}
                        {{ $application->user->middle_name }}
                        {{ $application->user->last_name }}</span></label>
            </div>
            <div style="padding: 0 0 0 1rem;">
                <label for="project_title"> Project
                    Title&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                    <span
                        style="margin-left: 0.8rem; text-decoration:underline;">{{ $application->property->project_title }}</span>

            </div>
            <div style="padding: 1rem;">
                <label for="location" style="padding: 1rem 0 0 0;"> Location of
                    Construction&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;
                    Street&nbsp;
                    :&nbsp;
                    <span style="text-decoration: underline;">{{ $application->property->property_address }}</span>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TCT
                    No. :<span style="text-decoration:underline">{{ $application->property->tct_no }}</span> <br>
                    <label
                        for="barangay">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        Barangay&nbsp;&nbsp;&nbsp;&nbsp;
                        :</label> &nbsp;&nbsp;&nbsp;<span
                        style="text-decoration: underline;">{{ $application->property->barangay }}</span>&nbsp;&nbsp;&nbsp;City
                    / Municipality : <span
                        style="text-decoration: underline;">{{ $application->property->municipality }}</span>
                    <br><label
                        for="zipcode">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ZIP
                        Code &nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;<span
                            style="text-decoration: underline;">4405</span></label>
            </div>
            <div style="padding: 0 0 0 1rem;"">
                <label for="occupancy">Character of Occupancy &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                    &nbsp;&nbsp;<span
                        style="text-decoration: underline;">{{ ucfirst($application->property->occupancy_type) }}</span>
                    &nbsp;&nbsp;Classified As : <span
                        style="text-decoration: underline;">{{ ucfirst($application->property->classified_as) }}</span>
            </div>

            <div style="padding: 1rem 0 0 1rem;">
                <label for="scope"> Scope of Work
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                    &nbsp;&nbsp;<span
                        style="text-decoration: underline;">{{ $application->property->scope_of_work }}</span>

            </div>
            <div style="padding: 1rem 0 0 1rem;">
                <label for="cost"> Total Project Cost
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:
                    &nbsp;&nbsp;<span style="text-decoration: underline;">{{ $application->property->estimated_cost }}
                        Pesos</span>

            </div>
            <div style="padding: 1rem 0 0 1rem;">
                <label>Professional in Charge of Construction:</label>
                <ul style="list-style-type:none; padding-left:0; margin-left: 1rem;">
                    @forelse ($application->professionals as $pro)
                        <li>
                            @php

                                $title = '';
                                if (Str::contains(strtolower($pro->prof_type ?? ''), 'architect')) {
                                    $title = 'Arch.';
                                } elseif (Str::contains(strtolower($pro->prof_type ?? ''), 'engineer')) {
                                    $title = 'Engr.';
                                }
                            @endphp

                            {{ $title }} {{ $pro->prof_name }}
                            @if (!empty($pro->prof_type))
                                – {{ $pro->prof_type }}
                            @endif
                            @if (!empty($pro->prc_no))
                                (PRC No. {{ $pro->prc_no }})
                            @endif
                        </li>
                    @empty
                        <li>N/A</li>
                    @endforelse
                </ul>
            </div>


        </div>
        <div style="margin-top: 1rem; text-align:center;">
            <h3 style="margin-top:1rem;">PERMIT ISSUED BY:</h3>

            <div style="margin-top: 0.5rem; position: relative; display: inline-block;">
                {{-- Signature image --}}
                <img src="{{ public_path('storage/signature/images-removebg-preview.png') }}"
                    alt="Building Official Signature"
                    style="width: 180px; height: 50px; display:block; margin: 0 auto;">

                {{-- Printed name --}}
                {{-- <h4 style="font-weight:600;">
                    {{ $application->approver->first_name }} {{ $application->approver->last_name }}
                </h4> --}}

                <hr style="width: 100%; margin: 0.3rem auto;">
                <h4 style="text-align: center;">BUILDING OFFICIAL</h4>
                <p style="text-align:center; font-size: 13px;">(Signature Over Printed Name)</p>
            </div>
        </div>


        <footer style="text-align: center;margin-top: 1rem; font:800;">
            <p>THIS PERMIT MAY BE CANCELLED OR REVOKED PURSUANT TO SECTIONS 207, 305, AND 306 OF THE NATIONAL BUILDING
                CODE OF THE PHILIPPINES (PD 1096) AND ITS REVISED IRR</p>
        </footer>

    </div>
</body>

</html>
