<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $letter->letter_number }}</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo/square.png') }}" />
    <style>
        body {
            padding: 0 .75em;
            font-family: 'Plus Jakarta Sans', serif;
            font-size: 0.8em
        }

        .dash-list {
            list-style: none;
            padding-left: 0;
        }

        .dash-list li::before {
            content: "- ";
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="header" style="padding-bottom: 20px; margin-top: -.75%;">
        <table style="width: 100%;">
            <tr>
                @php
                    $logo = file_get_contents(public_path('assets/img/logo/primary-bw.png'));
                    $baseLogo = 'data:image/png;base64,' . base64_encode($logo);
                @endphp
                <td style="width: 100%; text-align: right !important;">
                    <img src="{{ $baseLogo }}" alt="Logo" width="200px" style="margin-top: -15px;">
                </td>
            </tr>
        </table>
    </div>
    
    <div style="text-align: center;">
        <h2 style="margin-bottom: 2px;"><span style="border-bottom: 2px solid black">SURAT IZIN KERJA</span></h2>
        <h3 style="margin-top: 0; margin-bottom: 20px; font-family: sans-serif">NOMOR: {{ $letter->letter_number }}</h3>

        <p style="font-size: 1.1rem; margin-bottom: 5px;">TENTANG</p>
        <p style="font-size: 1.1rem; margin-top: 0;">PERPANJANGAN SURAT IZIN KERJA {{ strtoupper($letter->vendor->legal_name) }}</p>
    </div>

    <table style="width: 100%; font-size: 1.05rem; padding: 0 1rem; text-align: justify;">
        <tr style="vertical-align: top;">
            <td style="padding-right: 80px;">Dasar</td>
            <td>:</td>
            <td>
                <ol style="padding: 0; margin-top: -3px;">
                    @foreach ($fundamentals as $fundamental)
                        @if ($loop->last)
                            <li style="margin-bottom: 5px; line-height: 26px;">{{ $fundamental->reference }}.</li>
                        @else
                            <li style="margin-bottom: 5px; line-height: 26px;">{{ $fundamental->reference }};</li>
                        @endif
                    @endforeach
                </ol>
            </td>
        </tr>
        @php
            $provisionTextBefore = str_replace(["\r\n", "\r"], "\n", $letter->workType->provision_text_before);
            $provisionsBefore = explode("\n", $provisionTextBefore);
            $provisionTextAfter = str_replace(["\r\n", "\r"], "\n", $letter->workType->provision_text_after);
            $provisionsAfter = explode("\n", $provisionTextAfter);
            $pointingsText = str_replace(["\r\n", "\r"], "\n", $letter->pointing);
            $pointings = explode("\n", $pointingsText);
            $number = 3;
        @endphp
        <tr style="vertical-align: top;">
            <td>Menunjuk</td>
            <td>:</td>
            <td>
                <ol style="padding: 0; margin-top: -3px;">
                    @foreach ($pointings as $pointing)
                        @if (!empty(trim($pointing)))
                            @if ($loop->last)
                                <li style="margin-bottom: 5px; line-height: 26px;">{{ $pointing }}.</li>
                            @else
                                <li style="margin-bottom: 5px; line-height: 26px;">{{ $pointing }};</li>
                            @endif
                        @endif
                    @endforeach
                </ol>
            </td>
        </tr>
        <tr style="vertical-align: top;">
            <td colspan="3" style="text-align: center;"><h3>MENGIZINKAN</h3></td>
        </tr>
        <tr style="vertical-align: top;">
            <td>Kepada</td>
            <td>:</td>
            <td style="margin-left: -20px;">{{ $letter->vendor->legal_name }}</td>
        </tr>
        <tr style="vertical-align: top;">
            <td>Untuk</td>
            <td>:</td>
            <td>
                {{ $letter->description }}
                <span style="display: block; margin-top: -15px;">
                    <p style="padding-bottom: 0; margin-bottom: 5px;">Dengan pengawasan harian dari Unit {{ $letter->workType->unit_name }} Sebagai berikut:</p>
                    <ul style="list-style-type: none; margin-top: 0; margin-bottom: 5px;">
                        <li style="margin-bottom: 3px;">Nama: {{ $letter->internal_pic_name }}</li>
                        <li style="margin-bottom: 3px;">No HP: {{ $letter->internal_pic_number }}</li>
                    </ul>
                    <p style="padding-bottom: 0; margin-bottom: 5px; margin-top: 0;">Dengan Penanggung Jawab Pelaksanaan Pekerjaan dari {{ $letter->vendor->legal_name }}:</p>
                    <ul style="list-style-type: none; margin-top: 0; margin-bottom: 5px;">
                        <li style="margin-bottom: 3px;">Nama: {{ $letter->external_pic_name }}</li>
                        <li style="margin-bottom: 3px;">No HP: {{ $letter->external_pic_number }}</li>
                    </ul>
                </span>
            </td>
        </tr>
        <tr style="vertical-align: top; line-height: 26px;">
            <td>KETENTUAN</td>
            <td style="white-space: nowrap;"><span style="padding-right: 30px;">:</span> 1.&nbsp;&nbsp;</td>
            <td>Tanggal/Waktu: {{ $workDate }};</td>
        </tr>
        <tr style="vertical-align: top; line-height: 26px;">
            <td></td>
            <td style="white-space: nowrap;"><span style="padding-right: 30px;">&nbsp;</span>&nbsp;2.&nbsp;&nbsp;</td>
            <td>Lokasi: {{ $letter->workLocation->location }}{{ $letter->workLocation->description ? '(' . $letter->workLocation->description . ');' : ';' }}</td>
        </tr>
        @foreach ($provisionsBefore as $provision)
            @if (!empty(trim($provision)))
                <tr style="vertical-align: top; line-height: 26px;">
                    <td></td>
                    <td style="white-space: nowrap;"><span style="padding-right: 30px;">&nbsp;</span>&nbsp;{{ $number }}.&nbsp;&nbsp;</td>
                    <td>{{ $provision }};</td>
                </tr>
            @endif
            @php $number++ @endphp
        @endforeach
        <tr style="vertical-align: top; top; line-height: 26px;">
            <td></td>
            <td style="white-space: nowrap;"><span style="padding-right: 30px;">&nbsp;</span>&nbsp;{{ $number }}.&nbsp;&nbsp;</td>
            <td>Segala akibat dan resiko berkaitan dengan pekerjaan dimaksud menjadi tanggung jawab dari {{ $letter->vendor->legal_name }};</td>
        </tr>
        @php $number++ @endphp
        @foreach ($provisionsAfter as $provision)
            @if (!empty(trim($provision)))
                <tr style="vertical-align: top; line-height: 26px;">
                    <td></td>
                    <td style="white-space: nowrap;"><span style="padding-right: 30px;">&nbsp;</span>&nbsp;{{ $number }}.&nbsp;&nbsp;</td>
                    @if ($loop->last)
                        <td>{{ $provision }}.</td>
                    @else
                        <td>{{ $provision }};</td>
                    @endif
                </tr>
                @php $number++ @endphp
            @endif
        @endforeach
        <tr style="vertical-align: top; padding-top: 20px;">
            <td style="padding-top: 20px;"></td>
            <td style="padding-top: 20px;"></td>
            <td style="text-align: right; padding-top: 20px;">
                <table style="width: 100%; text-align: right;">
                    <tr>
                        <td>Dikeluarkan di</td>
                        <td>:</td>
                        <td style="">Batam</td>
                    </tr>
                    <tr>
                        <td>Pada Tanggal</td>
                        <td>:</td>
                        <td style="">{{ $issuedDate->translatedFormat('d F Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    @php
        $columnsPerRow = 2;
        $count = 0;
    @endphp

    <table style="width: 100%; font-size: 1.05rem; text-align: center; margin-top: 50px;">
        <tr style="vertical-align: top;">
            @foreach ($letter->approvalStages as $stage)
                @php
                    $sign = file_get_contents(public_path("storage/$stage->signature"));
                    $baseSign = 'data:image/png;base64,' . base64_encode($sign);

                    $remainingItems = $letter->approvalStages->count() - $count;
                    $isLastOdd = $loop->last && ($remainingItems % $columnsPerRow != 0);
                @endphp

                @if ($isLastOdd)
                    <td colspan="{{ $columnsPerRow }}" style="width: 100%;">
                @else
                    <td style="width: {{ 100 / $columnsPerRow }}%;">
                @endif
                        Menyetujui,
                        <span style="display: block">{{ $stage->position }}</span>
                        <img src="{{ $baseSign }}" alt="{{ $stage->position }}'s signature" style="width: 150px; height: 100px; object-fit: contain;">
                        <span style="display: block">{{ $stage->name }}</span>
                    </td>

                @php $count++; @endphp

                @if ($count % $columnsPerRow == 0 && !$loop->last)
                    </tr><tr style="vertical-align: top;">
                @endif
            @endforeach
        </tr>
    </table>

    <div style="font-size: 1.05rem; margin-top: 50px;">
        <p style="margin: 0; padding: 0;">Tembusan Yth. :</p>
        <ol style="margin-top: 0; padding-top: 5px; padding-left: 23px;">
            @foreach ($copies as $copy)
                <li>{{ $copy->name }}</li>
            @endforeach
        </ol>

        <p style="margin: 0; padding: 0;">Lampiran:</p>
        <ul class="dash-list" style="margin-top: 0; padding-top: 5px;">
            <li><a href="{{ asset("storage/$letter->application_letter") }}">Surat Permohonan</a></li>
            @if ($letter->job_safety_analysis_document)
                <li><a href="{{ asset("storage/$letter->job_safety_analysis_document") }}">JSA</a></li>
            @endif
        </ul>
    </div>

    {{-- <tr style="vertical-align: top; break-inside: auto; page-break-inside: auto;">
        <td>KETENTUAN</td>
        <td>:</td>
        <td style="padding-left: 20px;">
            <ol style="margin-top: -3px;">
                <li style="margin-bottom: 5px; line-height: 26px;">asd</li>
                <li style="margin-bottom: 5px; line-height: 26px;">asd</li>
                @foreach ($provisionsBefore as $provision)
                    @if (!empty(trim($provision)))
                        <li style="margin-bottom: 5px; line-height: 26px;">{{ $provision }};</li>
                    @endif
                @endforeach
            </ol>
        </td>
    </tr> --}}

    {{-- <ol style="margin-top: -3px;">
        <li style="margin-bottom: 5px; line-height: 26px;"></li>
        <li style="margin-bottom: 5px; line-height: 26px;"></li>
        @foreach ($provisionsBefore as $provision)
            @if (!empty(trim($provision)))
                <li style="margin-bottom: 5px; line-height: 26px;">{{ $provision }};</li>
            @endif
        @endforeach
    </ol> --}}

    {{-- <h2 style="margin-bottom: 3px; text-align: center;"></h2> --}}
    {{-- <div style="text-align: center;">
    </div> --}}

    {{-- <h2 style="margin-top: 40px; margin-left: 5px; margin-bottom: 0">QUOTATION</h2>

    <footer style="border-top: 1px solid rgb(182, 182, 182); padding-top: 15px; page-break-inside: avoid;">
        <table style="width: 100%;">
        </table>
    </footer> --}}
</body>
</html>