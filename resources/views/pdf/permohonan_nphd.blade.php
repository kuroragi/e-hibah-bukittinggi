@extends('pdf._app')

@push('style')
    <style>
        @page {
            size: 215mm 330mm;
            margin: 18mm 18mm 30mm 18mm;
        }

        @media print {
            @page {
                @top-center {
                    content: "Halaman " counter(page) " dari " counter(pages);
                }
            }
        }

        body {
            font-family: "Times New Roman", serif;
            max-width: 179mm;
            /* 215mm - 36mm (18mm * 2) */
            margin: 0 auto;
            line-height: 1.6;
            color: #000;
        }

        .judul-utama {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            line-height: 1.4;
            white-space: pre-line;
        }

        .nomor-surat {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .section-header {
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 1px solid #000;
            padding-bottom: 2px;
            margin-top: 15px;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .paragraph-indent {
            text-align: justify;
            text-indent: 8mm;
            margin-bottom: 10px;
        }

        .no-indent {
            text-align: justify;
            text-indent: 0;
            margin-bottom: 10px;
        }

        .pasal {
            font-weight: bold;
            margin-top: 15px;
            margin-bottom: 8px;
        }

        .ttd-space {
            height: 35mm;
            border: none;
        }

        .signature-area {
            page-break-inside: avoid;
            margin-top: 30px;
        }

        .page-break {
            page-break-before: always;
            /* versi lama */
            break-before: page;
            /* versi baru */
        }


        .signature-box {
            text-align: center;
            border: none;
        }

        .materai-box {
            width: 40px;
            height: 20px;
            border: 1px dashed #666;
            display: inline-block;
            margin: 5px;
            text-align: center;
            font-size: 8px;
            line-height: 20px;
        }

        table {
            page-break-inside: avoid;
        }

        th,
        td {
            word-break: break-word;
            vertical-align: top;
        }

        .currency {
            text-align: right;
        }

        ol {
            counter-reset: num;
            list-style: none;
            padding-left: 2em;
        }

        ol>li {
            counter-increment: num;
            text-indent: -1.75em;
            padding-left: 1.75em;
            text-align: justify !important;
            list-style: none;
            vertical-align: middle;
        }

        ol>li::before {
            content: counter(num) ". ";
            display: inline-block;
            width: 4ch;
            margin-right: 1em;
            text-align: left !important;
        }

        ol.angka-kurung {
            counter-reset: num;
            list-style: none;
            padding-left: 2em;
        }

        ol.angka-kurung>li {
            counter-increment: num;
            text-indent: -1.75em;
            padding-left: 1.75em;
            text-align: justify !important;
            list-style: none;
            vertical-align: middle;
        }

        ol.angka-kurung>li::before {
            content: "(" counter(num) ") ";
            display: inline-block;
            width: 4ch;
            margin-right: .5em;
            text-align: left !important;
        }

        ol.alpha {
            counter-reset: alpha;
            list-style: none;
            padding-left: 2em;
        }

        ol.alpha>li {
            counter-increment: alpha;
            text-indent: -1.75em;
            padding-left: 1.75em;
            text-align: justify !important;
            list-style: none;
            vertical-align: middle;
        }

        ol.alpha>li::before {
            content: counter(alpha, lower-alpha) ". ";
            display: inline-block;
            width: 4ch;
            margin-right: 1em;
            text-align: right !important;
        }

        li p {
            margin: 0;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .signature-col {
            width: 50%;
            vertical-align: top;
        }

        .materai-box {
            border: 1px dashed #000;
            width: 60px;
            height: 80px;
            margin: 10px auto;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ttd-space {
            height: 80px;
            /* ruang tanda tangan */
        }

        .signature-line {
            border-bottom: 1px solid #000;
            margin: 0 auto 5px auto;
            width: 80%;
            text-align: center;
        }

        /* Print specific styles */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .page-break {
                page-break-before: always;
            }
        }

        /* Page counter for print */
        body {
            counter-reset: page-number;
        }

        @media print {
            @page {
                @bottom-center {
                    content: "- " counter(page) " -";
                    font-family: "Times New Roman", serif;
                    font-size: 10px;
                }
            }
        }

        /* Footer akan muncul di semua halaman */
        footer {
            position: fixed;
            bottom: -45px;
            /* sesuaikan posisi agar pas */
            left: 0;
            right: 0;
            height: 60px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
        }

        .footer-left {
            transform: rotate(-2deg);
            transform-origin: left bottom;
            font-style: italic;
            font-size: 11px;
            padding-left: 5px;
        }

        .footer-right {
            border: 1px solid #000;
            width: 180px;
            font-size: 10.5px;
            margin-right: 10px;
        }

        .footer-right table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-right td {
            border: 1px solid #000;
            padding: 2px 4px;
        }

        .signature {
            height: 50px;
        }

        @media print {
            .nphd-content {
                page-break-inside: avoid;
            }

            .header_block {
                page-break-inside: avoid;
            }
        }

        tr.p-0 td {
            padding: 0;
        }
    </style>
@endpush

@section('pdf-content')
    <div class="nphd-content">

        <table style="border-bottom: 2px black solid; margin-bottom: 1rem;">
            <tr>
                <td style="width: 125px;">
                    <img src="{{ optional($data->lembaga)->photo ? storage_path('app/public/' . $data->lembaga->photo) : '' }}"
                        width="115px" alt="" />
                </td>
                <td class="text-center">
                    <h2>{{ strtoupper($data->lembaga->name) }}<br>KOTA BUKITTINGGI</h2>
                    <span>{{ $data->lembaga->alamat }} telp. {{ $data->lembaga->phone }}, Bukittinggi - Sumatera
                        Barat</span><br>
                    <span>Email: {{ $data->lembaga->email }}</span><br>
                </td>
                <td style="width: 125px;"><img src="{{ public_path('assets/images/logo/bkt.png') }}" width="115px"
                        alt="" />
                </td>
            </tr>
        </table>
        <div class="container-fluid">

            <table class="table table-borderless">
                <tr class="p-0">
                    <td style="width: 6rem;" class="ps-0">Nomor</td>
                    <td>: XXX/XX/XX/XXX</td>
                    <td class="text-end" style="padding-right: 1rem;">Bukittinggi,
                        {{ date('d-m-Y', strtotime(now())) }}</td>
                </tr>
                <tr class="p-0">
                    <td class="ps-0">Lampiran</td>
                    <td colspan="2">: 1 (satu) berkas</td>
                </tr>
                <tr class="p-0">
                    <td class="ps-0">Perihal</td>
                    <td colspan="2">: Mohon Pencairan</td>
                </tr>
                <tr class="p-0">
                    <td></td>
                    <td colspan="2" style="padding-bottom: 2rem;">&nbsp;&nbsp;Dana Hibah Tahun </td>
                </tr>

                <!-- pembahasan permintaan nphd -->
                <tr class="pt-5">
                    <td></td>
                    <td colspan="2" style="padding-bottom: 2rem;">
                        Kepada Yth:<br>
                        <strong>Walikota Bukittinggi</strong><br>
                        <strong>Cq.
                            {{ ucwords($data->lembaga->skpd->type . ' ' . $data->lembaga->skpd->name) }}</strong><br>
                        Kota Bukittinggi<br>
                        di<br>
                        Bukittinggi
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="2" style="text-align: justify; padding-right: 1rem;">
                        Salam Olahraga,<br>
                        Dengan Hormat,<br>
                        Sehubungan dengan telah dialokasikannya Dana Hibah Tahun {{ $data->tahun_apbd }} oleh
                        Pemerintah
                        Kota Bukittinggi kepada {{ ucwords($data->lembaga->name) }}
                        ({{ strtoupper($data->lembaga->acronym) }}) Kota Bukittinggi,
                        Sebesar Rp {{ number_format($nominal_anggaran, 0, ',', '.') }},-
                        ({{ ucwords(strtolower(App\Helpers\General::Terbilang($nominal_anggaran))) }} Rupiah)..<br><br>

                        Maka bersama surat ini kami mengajukan permohonan kepada Bapak untuk dapat
                        Merealisasikan Pencairan Dana Hibah Tahun 2025 tersebut. Sebagai bahan
                        pertimbangan turut kami lampirkan : <br><br>

                        <ol>
                            <li class="w-0" style="padding-bottom: 2rem;">
                                Rencana Anggaran Biaya Dana Hibah KONI Kota Bukittinggi Tahun {{ $data->tahun_apbd }} yang
                                telah melalui proses internal KONI Kota Bukittinggi dan Verifikasi dengan Team MONEV
                                DISPORA Kota Bukittinggi sebesar Rp
                                {{ number_format($nominal_anggaran, 0, ',', '.') }},-
                                ({{ ucwords(strtolower(App\Helpers\General::Terbilang($nominal_anggaran))) }} Rupiah).
                            </li>
                            <li class="w-0" style="padding-bottom: 2rem;">
                                Surat Keputusan Komite Olahraga Nasional Indonesia (KONI) Provinsi Sumatera
                                Barat Nomor {{ $data->lembaga?->nphdLembaga?->nomor_pengukuhan }} tentang
                                {{ $data->lembaga?->nphdLembaga?->tentang_pengukuhan }} Masa Bakti
                                {{ $data->lembaga?->nphdLembaga?->masa_bakti }}.
                            </li>
                        </ol>
                    </td>
                </tr>
            </table>
            <table class="table table-borderless">
                <tr class="p-0">
                    <td style="width: 6rem;"></td>
                    <td style="text-align: justify; padding-right: 1rem;">
                        Demikian Surat Permohonan Pencairan Dana Hibah KONI Kota Bukittinggi Tahun
                        {{ $data->tahun_apbd }}
                        ini disampaikan, atas perhatian dan bantuan yang diberikan diucapkan terimakasih.<br>
                        Salam Olahraga.
                    </td>
                </tr>
            </table>
            <table class="table-borderless">
                <tr>
                    <td style="width: 400px;"></td>
                    <td style="padding-bottom: 5rem;">
                        Hormat Kami,<br>
                        {{ strtoupper($data->lembaga->name) }}<br>
                        Kota Bukittinggi
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <strong>{{ strtoupper($pimpinan_lembaga->name) }}</strong><br>
                        {{ $pimpinan_lembaga->jabatan }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> --}}
@endsection
