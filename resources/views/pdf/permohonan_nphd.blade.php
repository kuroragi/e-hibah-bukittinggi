@extends('pdf._app')

@section('pdf-content')
    <div class="container">
        <table class="table table-borderless">
            <tr>
                <td style="width: 10%;">Nomor</td>
                <td style="width: 1%;">:</td>
                <td style="width: 39%;"></td>
                <td class="text-end">{{ App\Helpers\General::getIndoDate(now()) }}</td>
            </tr>
            <tr>
                <td>Sifat</td>
                <td>:</td>
                <td></td>
                <td class="text-center">
                    <dt>Kepada</dt>
                </td>
            </tr>
            <tr>
                <td>Lampiran</td>
                <td>:</td>
                <td></td>
                <td class="text-center" rowspan="2">Yth. Kepala Bidang
                    {{ $data->urusan_skpd?->nama_urusan }}<br>{{ ucwords($data->skpd?->name) }}</td>
            </tr>
            <tr>
                <td>Hal</td>
                <td>:</td>
                <td class="text-wrap">Permohonan Penandatanganan NPHD a.n. {{ $data->lembaga?->name }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="ps-2">Di</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="text-center">
                    <dt>Bukittinggi</dt>
                </td>
            </tr>
        </table>
    </div>

    <div class="container">
        <div class="letter-details">
            <p>Sehubungan dengan Permohonan Hibah Daerah yang diajukan, Kami:</p>
        </div>

        <div class="letter-details">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ ucwords($data->lembaga?->name) }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td>{{ ucwords($data->lembaga?->alamat) }}</td>
                </tr>
                <tr>
                    {{ dd($data) }}
                    <td>Nominal Sebesar</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($data->nominal_anggaran, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>({{ ucwords(App\Helpers\General::Terbilang($data->nominal_anggaran) . ' Rupiah') }})</td>
                </tr>
            </table>
        </div>

        <div class="letter-body">
            <p>dengan ini disampaikan hal sebagai berikut:</p>

            <ol class="numbered-list">
                <li>Rincian anggaran biaya/rencana penggunaan Hibah definitif telah sesuai dengan rincian anggaran
                    biaya. Rencana penggunaan hibah yang direkomendasikan oleh bidang olahraga Dinas pemuda dan olahraga.
                </li>
                <li>berkenaan hal tersebut kami mohon untuk dapat dilaksanakan penandatangan naskah perjanjian hibah daerah
                    sesuai dengan ketentuan yang tercantum dalam peraturan gubernur no 27 tahun 2023 tentang perubahan atas
                    peraturan gubernur nomor 35 tahun 2021 tentang tata cara pemberian hibah dan bantuan sosial.</li>
            </ol>
        </div>

        <div class="closing">
            <p>Demikian surat permohonan penandatangan NPHD ini disampaikan dan kerja samanya diucapkan terimakasih</p>
        </div>

        <div class="signature-section">
            <div class="signature-location">
                <strong>PENERIMA HIBAH,</strong>
            </div>

            <div style="margin-top: 60px;">
                <div class="signature-name">
                    <strong>( meterai 10.000 )</strong>
                </div>
                <div class="signature-title">
                    <strong>({{ ucwords($data->lembaga?->pengurus?->where('jabatan', 'Pimpinan')->first()->name) }})</strong>
                </div>
            </div>
        </div>
    </div>
@endsection
