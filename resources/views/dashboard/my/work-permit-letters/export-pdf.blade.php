<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $letter->letter_number }}</title>
    <!-- Favicon -->
    {{-- <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/logo.svg') }}" /> --}}
    <style>
        body {
            padding: 0 .5em;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.8em
        }
    </style>
</head>
<body>
    <div class="header" style="padding-bottom: 20px; border-bottom: 1px solid rgb(204, 204, 204); margin-top: -.75%;">
        <table style="width: 100%;">
            <tr>
                @php
                    $logo = file_get_contents(public_path('assets/img/logo/primary.png'));
                    $baseLogo = 'data:image/png;base64,' . base64_encode($logo);
                @endphp
                <td style="width: 100%, text-align: right;">
                    <img src="{{ $baseLogo }}" alt="Marhaba Logo" width="150px" style="margin-top: 15px;">
                </td>
                {{-- <td style="text-align: right;">
                    <table style="text-align: right; width: 100%;">
                        <tr class="spaceUnder">
                            <td><h4 style="font-size: 12px; margin-bottom: 0;">Quality Aviation Services</h4></td>
                        </tr>
                        <tr>
                            <td style="margin-bottom: 1px; padding-bottom: 1px; font-size: 10.5px">2716, Hussain Ali Tabri District , AL Zahra,</td>
                        </tr>
                        <tr>
                            <td style="margin-bottom: 1px; padding-bottom: 1px; font-size: 10.5px">Jeddah, 23425 Saudi Arabia</td>
                        </tr>
                        <tr>
                            <td style="margin-bottom: 1px; padding-bottom: 1px; font-size: 10.5px">Company Registration No: 4030428850</td>
                        </tr>
                        <tr>
                            <td style="margin-bottom: 1px; padding-bottom: 1px; font-size: 10.5px">VAT Registration No: 311028053600003</td>
                        </tr>
                    </table>
                </td> --}}
            </tr>
        </table>
    </div>

    <h2 style="margin-top: 40px; margin-left: 5px; margin-bottom: 0">QUOTATION</h2>

    <footer style="border-top: 1px solid rgb(182, 182, 182); padding-top: 15px; page-break-inside: avoid;">
        <table style="width: 100%;">
        </table>
    </footer>
</body>
</html>