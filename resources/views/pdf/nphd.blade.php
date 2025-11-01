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
                    <span>NASKAH PERJANJIAN HIBAH DAERAH DALAM</span><br>
                    <span>ANTARA</span><br>
                    <span>PEMERINTAH KOTA BUKITTINGGI</span><br>
                    <span>DENGAN</span><br>
                    <span>{{ $data->lembaga?->acronym }} KOTA BUKITTINGGI</span><br><br>
                    <span style="font-size: 0.8rem;">PEMBERIAN UNTUK PELAKSANAAN PROGRAM DAN KEGIATAN</span><br>
                    <span style="font-size: 0.8rem;">{{ strtoupper($data->lembaga?->acronym) }} KOTA BUKITTINGGI TAHUN
                        ANGGARAN
                        {{ $data->tahun_apbd }}</span><br>
                    <div class="signature-line mb-0">
                        Nomor: {{ $nomor_skpd }}
                    </div>
                    <div class="mb-3">
                        Nomor: {{ $nomor_lembaga }}
                    </div>
                </td>
                <td style="width: 125px;"><img src="{{ public_path('assets/images/logo/bkt.png') }}" width="115px"
                        alt="" />
                </td>
            </tr>
        </table>
        <div class="container-fluid">

            <!-- Nomor Surat -->

            <!-- Para Pihak -->
            <div class="mb-4">
                <p class="no-indent">
                    Pada hari ini <span class="fw-bold">{{ $waktu['hari'] }}</span> tanggal <span
                        class="fw-bold">{{ $waktu['tanggal'] }}</span> bulan <span
                        class="fw-bold">{{ $waktu['bulan'] }}</span> Tahun
                    <span class="fw-bold">{{ $waktu['tahun'] }}
                        ({{ date('d-m-Y', strtotime($waktu['tanggal_penuh'])) }})</span>, bertempat di Bukittinggi. Kami
                    yang bertanda tangan di bawah
                    ini:
                </p>

                <table class="table">
                    <tr class="pb-3">
                        <td class="text-start" style="width:6ch;">I</td>
                        <td style="width: 35%" class="fw-bold">{{ $data->skpd?->detail?->nama_pimpinan }}</td>
                        <td style="width: 60%; text-align:justify;"><span class="fw-bold">NIP.
                                {{ $data->skpd?->detail?->nip_pimpinan }}</span>
                            selaku
                            {{ $data->skpd?->detail?->jabatan }} nama {{ $data?->lembaga?->skpd?->name }} dalam hal ini
                            bertindak dalam jabatannya untuk dan atas nama Pemertintah Kota Bukittinggi, berkedudukan dan
                            beralamat di {{ $data->lembaga?->alamat }}, selanjutnya disebut sebagai Pemberi Hibah selaku
                            <span class="fw-bold">PIHAK PERTAMA</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-start">II</td>
                        <td class="fw-bold">{{ strtoupper($pimpinan_lembaga->name) }}</td>
                        <td style="text-align: justify;">Selaku {{ $data->lembaga?->pengurus[0]?->jabatan }}
                            {{ $data->lembaga?->name }} ({{ $data->lembaga?->acronym }}) Kota Bukittinggi berdasarkan
                            surat keputusan {{ $data->lembaga?->nphdLembaga?->pemberi_amanat }} Nomor :
                            {{ $data->lembaga?->nphdLembaga?->nomor_pengukuhan }} Tanggal
                            {{ App\Helpers\General::getIndoDate($data->lembaga?->nphdLembaga?->tanggal_pengukuhan) }},
                            tentang
                            {{ $data->lembaga?->nphdLembaga?->tentang_pengukuhan }} Masa Bakti
                            {{ $data->lembaga?->nphdLembaga?->masa_bakti }}, dalam hal ini bertindak dalam jabatannya
                            untuk dan atas nama {{ $data->lembaga?->acronym }} Kota
                            Bukittinggi, beralamat di {{ $data->lembaga?->alamat }},
                            {{ $data->lembaga?->kelurahan?->name }}, {{ $data->lembaga?->kelurahan?->kecamatan?->name }},
                            {{ $data->lembaga?->kelurahan?->kecamatan?->kabkota?->name }},
                            {{ $data->lembaga?->kelurahan?->kecamatan?->kabkota?->propinsi?->name }}
                            Selanjutnya disebut <span class="fw-bold">PIHAK EDUA</span>.
                        </td>
                    </tr>
                </table>
            </div>

            <p class="no-indent mb-3">PIHAK PERTAMA dan PIHAK KEDUA selanjutnya secara bersama-sama disebut sebagai PARA
                PIHAK,
                dan
                secara sendiri-sendiri disebuk PIHAK, terlebih dahulu menerangkan hal-hal sebagai berikut:</p>
            <ol class="mb-3">
                <li>PIHAK PERTAMA adalah {{ $data->skpd?->deskripsi }};</li>
                <li>PIHAK PERTAMA sebagai penyelenggara sebagian urusan pemerintahan daerah menurut asas otonomi dengan
                    kewenangan, hak dan kewajiban untuk mengatur serta mengurus sendiri urusan pemerintahan dan kepentingan
                    masyarakat setempat di bidang
                    {{ App\Helpers\General::formatBidangList($data->skpd?->has_urusan?->pluck('nama_urusan')->toArray()) }}
                    sesuai ketentuan peraturan perundang-undangan;</li>
                <li>PIHAK KEDUA adalah pimpinan {{ ucwords($data->lembaga?->name) }} ({{ $data->lembaga?->acronym }}) Kota
                    Bukittinggi selaku
                    {{ $data->lembaga?->nphdLembaga?->deskripsi }} sebagaimana dimaksud dalam
                    Surat
                    Keputusan {{ $data->lembaga?->nphdLembaga?->pemberi_amanat }} Nomor :
                    {{ $data->lembaga?->nphdLembaga?->nomor_pengukuhan }} Tanggal
                    {{ App\Helpers\General::getIndoDate($data->lembaga?->nphdLembaga?->tanggal_pengukuhan) }}.</li>
            </ol>
            <p class="no-indent mb-3">PIHAK PERTAMA dan PIHAK KEDUA dengan mendasarkan dan memperhatikan hal sebagai
                berikut:
            </p>
            <ol class="mb-3">
                @foreach (json_decode($data->lembaga?->skpd?->detail?->perhatian_nphd) as $item)
                    <li>{{ $item->uraian }}</li>
                @endforeach
                @foreach (json_decode($data->lembaga?->nphdLembaga?->uraian) as $item)
                    <li>{{ $item->uraian }}</li>
                @endforeach
            </ol>

            <p class="no-indent mb-3">Dengan ini sepakat untuk melaksanakan Perjanjian Hibah Daerah, dengan ketentuan dan
                syarat-syarat sebagai berikut:</p>

            <div class="w-100 mb-3 text-center header_block">
                <h6 class="fw-bold">Pasal 1</h6>
                <h6 class="fw-bold">OBJEK PERJANJIAN</h6>
            </div>

            <p class="no-indent mb-3">PIHAK PERTAMA menyerahkan Hibah Berupa Uang kepada PIHAK KEDUA dan PIHAK KEDUA
                menerima
                Hibah Berupa Uang dari PIHAK PERTAMA sebesar:
                <span class="fw-bold">Rp. {{ number_format($nominal_anggaran, 0, ',', '.') }},-
                    ({{ strtolower(App\Helpers\General::Terbilang($nominal_anggaran)) }} rupiah)</span>,
            </p>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 2</h6>
                <h6 class="fw-bold">Ruang Lingkup</h6>
            </div>

            <ol class="mb-3 angka-kurung">
                <li>Hibah sebagaimana dimaksud Pasal 1 ini adalah dana yang telah dianggarkan dalam Anggaran Pendapatan dan
                    Belanja Daerah Kota Bukittinggi Tahun Anggaran {{ $data->tahun_apbd }} @foreach ($kegiatan_urusan as $kegiatan)
                        @foreach ($kegiatan['sub_kegiatan'] as $sub_kegiatan)
                            Rekening Nomor:
                            {{ App\Helpers\General::formatBidangList($sub_kegiatan['rekening_anggaran'], 'rekening') }},
                            Subkegiatan {{ $sub_kegiatan['nama_sub_kegiatan'] }}
                        @endforeach pada Kegiatan {{ $kegiatan['nama_kegiatan'] }}
                    @endforeach;</li>
                <li>Dana hibah sebagaimana dimaksud pada ayat (1) dipergunakan untuk kegiatan KONI Kota Bukittinggi Tahun
                    Anggaran 2025 sesuai dengan Rincian Anggaran Biaya Pelaksanaan Program dan Kegiatan Tahun Anggaran
                    {{ $data->tahun_apbd }}
                    yang
                    menjadi bagian yang tidak terpisahkan dari Naskah Perjanjian Hibah Daerah ini.</li>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 3</h6>
                <h6 class="fw-bold">JANGKA WAKTU</h6>
            </div>

            <p class="no-indent mb-3">
                Perjanjian ini berlaku terhitung sejak Naskah Perjanjian Hibah Daerah ini ditandatangani sampai dengan
                tanggal
                {{ App\Helpers\General::getIndoDate($data->akhir_laksana) }}.
            </p>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 4</h6>
                <h6 class="fw-bold">PENYERAHAN DANA HIBAH</h6>
            </div>

            <ol>
                <li>Sebelum bantuan hibah diserahkan kepada PIHAK KEDUA, terlebih dahulu PIHAK PERTAMA meminta Pakta
                    Integritas
                    terkait dengan penggunaan hibah dan nomor rekening tersendiri atas nama Dana Hibah KONI Kota
                    Bukittinggi,
                    sehingga hibah terpisah dari keuangan KONI Kota Bukittinggi lainnya.</li>
                <li>Penyerahan hibah dilakukan secara sekaligus sebesar <span class="fw-bold">Rp.
                        {{ number_format($nominal_anggaran, 0, ',', '.') }},-
                        ({{ strtolower(App\Helpers\General::Terbilang($nominal_anggaran)) }}
                        rupiah).</span>
                </li>
                <li>Penyerahan hibah dibuktikan dengan Berita Acara Serah Terima Hibah yang ditandatangani oleh PIHAK
                    PERTAMA
                    dan PIHAK KEDUA.</li>
                <li>Bahwa selama penempatan dana hibah pada bank yang ditunjuk, PIHAK KEDUA belum mempergunakan dana hibah
                    tersebut untuk tujuan sebagaimana dimaksud Pasal 2 ayat (2) perjanjian ini maka seluruh bunga atau hasil
                    yang ditimbulkan dari penempatan tersebut merupakan satu kesatuan dari dana hibah dimaksud.
                </li>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 5</h6>
                <h6 class="fw-bold">LAPORAN PENGGUNAAN DANA HIBAH</h6>
            </div>

            <ol class="angka-kurung mb-3">
                <li>Dalam penggunaan hibah PIHAK KEDUA membuat Laporan Penggunaan Hibah dan menyerahkannya kepada PIHAK
                    PERTAMA.
                </li>
                <li>Laporan penggunaan hibah sebagaimana dimaksud ayat (1) diberikan oleh PIHAK KEDUA kepada PIHAK PERTAMA
                    dengan melampirkan:</li>
                <ol class="alpha">

                    <li>Laporan pelaksanaan Program dan Kegiatan {{ $data->lembaga?->acronym }} Kota Bukittinggi Tahun
                        Anggaran
                        {{ $data->tahun_apbd }};
                    </li>
                    <li>Laporan keuangan atau realisasi penggunaan dana hibah;</li>
                    <li>Foto copy keadaan rekening terakhir (saat Laporan Penggunaan Hibah diajukan);</li>
                    <li>Laporan realisasi fisik;</li>
                    <li>Surat pernyataan tanggung jawab, yang menyatakan bahwa hibah yang telah diterima, telah digunakan
                        sesuai
                        peruntukan yang telah disepakati;</li>
                    <li>Surat Tanda Setoran (STS) ke Kas Daerah Kota Bukittinggi atas sisa dana hibah dan/atau bunga yang
                        ditimbulkan dari penempatan dana hibah di rekening.</li>
                </ol>

                <li>Laporan Penggunaan Hibah sebagaimana dimaksud ayat (2) disampaikan oleh PIHAK KEDUA paling lambat
                    tanggal 7
                    Januari
                    {{ $data->tahun_apbd + 1 }}.</li>

                <li>Berdasarkan Laporan Penggunaan Hibah PIHAK KEDUA beserta lampiran sebagaimana tersebut pada ayat (2)
                    maka
                    PIHAK
                    PERTAMA dapat melakukan audit terhadap penggunaan hibah dengan menggunakan auditor yang ditunjuk oleh
                    PIHAK
                    PERTAMA ketentuan yang berlaku.</li>

                <li>Pelaksanaan audit sebagaimana dimaksud pada ayat (4) dapat dilakukan pada waktu lain yang ditentukan
                    oleh
                    PIHAK PERTAMA.</li>

                <li>Disamping audit sebagaimana dimaksud pada ayat (4) dam (5), PIHAK PERTAMA dapat melakukan pengawasan
                    tidak
                    langsung terhadap penggunaan hibah..</li>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 6</h6>
                <h6 class="fw-bold">HAK DAN KEWAJIBAN</h6>
            </div>

            <ol class="angka-kurung mb-3">
                <li>Hak PIHAK PERTAMA :</li>
                <ol class="alpha">
                    <li>Meminta nomor rekening tersendiri sebagaimana dimaksud Pasal 4 ayat (1);</li>
                    <li>Meminta kelengkapan yang dibutuhkan dalam rangka proses monitoring dan evaluasi yang dilaksanakan
                        oleh
                        PIHAK
                        PERTAMA terkait dengan penggunaan dana hibah daerah;</li>
                    <li>Menerima laporan penggunaan dana hibah beserta lampirannya dari PIHAK KEDUA sebagaimana dimaksud
                        Pasal
                        5;</li>
                    <li>Menerima pengembalian sisa dana hibah dan/atau bunga yang timbul dari penempatan dana hibah di
                        rekening;
                    </li>
                    <li>Menunjuk auditor dalam melakukan audit terhadap penggunaan hibah sebagaimana dimaksud Pasal 5 ayat
                        (4);
                    </li>
                    <li>Melakukan pengawasan tidak langsung terhadap penggunaan hibah sebagaimana dimaksud Pasal 5 ayat (6);
                    </li>
                    <li>Menerima Surat Pernyataan Tanggung Jawab yang menyatakan bahwa hibah yang diterima telah digunakan
                        sesuai
                        perjanjian hibah ini paling lambat tanggal 10 Januari 2026;</li>
                    <li>Menunda pencairan dana hibah apabila PIHAK KEDUA tidak atau belum memenuhi persyaratan yang telah
                        ditetapkan.</li>
                </ol>
                <li>Kewajiban PIHAK PERTAMA :</li>
                <ol class="alpha">
                    <li>Menyerahkan dana hibah kepada PIHAK KEDUA sebagaimana dimaksud pada Pasal 4, apabila seluruh
                        persyaratan
                        dan
                        kelengkapan berkas pengajuan hibah telah dipenuhi oleh PIHAK KEDUA dan dinyatakan lengkap dan benar
                        oleh
                        PIHAK
                        PERTAMA;</li>
                    <li>Secara bersama-sama dengan PIHAK KEDUA menandatangani Berita Acara Serah Terima Hibah sebagaimana
                        dimaksud
                        Pasal 4 ayat (3);</li>
                    <li>Melakukan audit sebagaimana dimaksud pada Pasal 5 ayat (4) dan (5).</li>
                </ol>
                <li>Hak PIHAK KEDUA :</li>
                <ol class="alpha">
                    <li>Menerima penyerahan dana hibah dari PIHAK PERTAMA sebagaimana dimaksud pada Pasal 4, apabila
                        seluruh
                        persyaratan dan kelengkapan berkas pengajuan dana hibah telah dipenuhi oleh PIHAK KEDUA dan
                        dinyatakan lengkap
                        dan benar oleh PIHAK PERTAMA;</li>
                    <li>Menggunakan dana hibah sebagaimana dimaksud pada Pasal 2 ayat (2).</li>
                </ol>
                <li>Kewajiban PIHAK KEDUA :</li>
                <ol class="alpha">
                    <li>Mempergunakan dana hibah sesuai dengan tujuan pemberian hibah sebagaimana dimaksud dalam Pasal 2
                        ayat
                        (2)
                        yang disesuaikan dengan Rincian Anggaran Biaya (RAB) Pelaksanaan Program dan Kegiatan KONI Kota
                        Bukittinggi
                        Tahun Anggaran {{ $data->tahun_apbd }} (Rincian Anggaran Biaya tersebut merupakan satu kesatuan
                        yang tak terpisahkan
                        dengan
                        Perjanjian ini);</li>
                    <li>Menandatangani Pakta Integritas yang menyatakan bahwa hibah yang diterima akan dipergunakan sesuai
                        dengan
                        perjanjian hibah ini;</li>
                    <li>Melaksanakan dan bertanggung jawab penuh secara formal dan material atas penggunaan hibah untuk KONI
                        Kota
                        Bukittinggi yang bersumber dari dana hibah daerah dan telah disetujui PIHAK PERTAMA dengan
                        berpedoman
                        pada
                        ketentuan perundang-undangan yang berlaku;</li>
                    <li>Menandatangani serta menyerahkan kepada PIHAK PERTAMA Surat Pernyataan Tanggung Jawab yang
                        menyatakan
                        bahwa hibah yang diterima telah digunakan sesuai perjanjian hibah ini paling lambat tanggal 10
                        Januari
                        2026;</li>
                    <li>Menyediakan kelengkapan yang dibutuhkan dalam rangka proses monitoring dan evaluasi yang
                        dilaksanakan
                        oleh PIHAK PERTAMA terkait dengan penggunaan dana hibah daerah;</li>
                    <li>Melaksanakan pengadaan barang/jasa dengan berpedoman kepada Rencana Anggaran Biaya (RAB) yang telah
                        diverifikasi dan disahkan oleh Satuan Kerja Perangkat Daerah (SKPD) teknis terkait;</li>
                    <li>Menyetor sisa dana hibah/bunga yang ditimbulkan dari penempatan dana hibah di rekening bank kepada
                        PIHAK
                        PERTAMA, dalam rangka optimalisasi program dan kegiatan KONI Kota Bukittinggi Tahun Anggaran
                        {{ $data->tahun_apbd }}
                        telah
                        diselesaikan;</li>
                    <li>Menjaga dan mempergunakan bukti-bukti pengeluaran yang lengkap dan sah sesuai peraturan
                        perundang-undangan dalam rangka PIHAK KEDUA selaku obyek pemeriksaan;</li>
                    <li>Membuat dan memberikan Laporan Penggunaan Hibah kepada PIHAK PERTAMA sebagaimana dimaksud Pasal 5
                        perjanjian ini, paling lambat tanggal 10 Januari 2026.</li>
                </ol>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 7</h6>
                <h6 class="fw-bold">KETENTUAN PAJAK</h6>
            </div>

            <p class="no-indent mb-3">Segala ketentuan pajak yang timbul akibat pelaksanaan perjanjian ini, ditanggung oleh
                {{ $data->lembaga?->name }} Kota
                Bukittinggi sesuai
                dengan ketentuan peraturan perundang-undangan.</p>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 8</h6>
                <h6 class="fw-bold">WANPRESTASI</h6>
            </div>

            <ol class="angka-kurung mb-3">


                <li>Wanprestasi adalah apabila PIHAK PERTAMA atau PIHAK KEDUA tidak memenuhi atau lalai melaksanakan
                    kewajibannya
                    sebagaimana yang dimaksud pada Pasal 6 ayat (2) dan ayat (4). Perjanjian ini akan diselesaikan yang
                    diatur
                    dalam
                    Buku III Kitab Undang-undang Hukum Perdata;</li>

                <li>Apabila salah satu pihak terbukti melakukan wanprestasi, maka pihak lainnya dalam perjanjian ini dapat
                    mengenakan
                    sanksi dengan terlebih dahulu memberikan peringatan/teguran tertulis kepada pihak yang wanprestasi
                    minimal
                    sebanyak
                    3 (tiga) kali dengan jarak waktu masing-masing 1 (satu) minggu.</li>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center">
                <h6 class="fw-bold">Pasal 9</h6>
                <h6 class="fw-bold">SANKSI</h6>
            </div>

            <ol class="angka-kurung mb-3">

                <li>Dalam hal PIHAK PERTAMA setelah melakukan monitoring dan evaluasi terhadap pemberian hibah sebagaimana
                    dimaksud pada
                    Pasal 6 ayat (1) huruf “b” jika terdapat penyimpangan penggunaan hibah yang tidak sesuai dengan tujuan
                    penggunaan hibah sebagaimana dimaksud pada pasal 2 ayat (2), maka kepada PIHAK KEDUA dikenakan sanksi
                    berupa
                    pengambilan dana hibah yang telah diterima kepada PIHAK PERTAMA dan atau PIHAK PERTAMA dapat mengakhiri
                    perjanjian secara sepihak</li>
                <li>Dalam hal PIHAK KEDUA tidak melaksanakan kewajibannya sebagaimana dimaksud pasal 6 ayat (4), maka PIHAK
                    KEDUA dikenakan sanksi berupa:</li>
                <ol class="alpha">
                    <li>Penerepan sanksi sesuai dengan perundang-undangan;</li>
                    <li>Penerapan tuntutan ganti rugi oleh Pemerintah Kota Bukittinggi berupa pengembalian dana hibah yang
                        terbukti disalahgunakan ke kas Daerah Kota Bukittinggi;</li>
                    <li>Penerepan proses hukum, yaitu mulai dari penyelidikan, penyidikan dan proses peradilan bagi pihak
                        yang
                        diduga atau terbukti melakukan penyimpangan dana hibah;</li>
                </ol>

                <li>Dalam hal PIHAK PERTAMA setelah melakukan audit terhadap penggunaan bantuan hibah sebagaimana dimaksud
                    pada
                    pasal 5 ayat (4) dan ayat (5) pernjanjian ini terdapat penyimpangan penggunaan hibah yang tidak sesuai
                    dengan tujuan penggunaan hibah sebagaimana dimaksud pada pasal 2 ayat (2) perjanjian ini, makan PIHAK
                    KEDUA
                    dikenakan sanksi berupa pengembalian sebagian atau seluruhnya dana hibah yang telah diberikan oleh PIHAK
                    PERTAMA dan/atau PIHAK PERTAMA dapat mengakhiri perjanjian secara sepihak;</li>

                <li>Dalam hal PIHAK KEDUA tidak melaksanakan program dan kegiatan {{ $data->lembaga?->acronym }} Kota
                    Bukittinggi sebagaimana pasal 2 ayat (2), maka PIHAK KEDUA dikenakan sanksi berupa pengembalian seluruh
                    dana hibah yang diberikan beserta bunga yang ditimbulkan atas penempatan dana hibah pada rekening PIHAK
                    KEDUA dan atau PIHAK PERTAMA dapat membatalkan perjanjian secara sepihak;</li>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 10</h6>
                <h6 class="fw-bold">PEMBERITAHUAN DAN KORESPONDENSI</h6>
            </div>

            <ol class="angka-kurung mb-3">
                <li class="mb-3">Segala macam pemberitahuan dan surat-menyurat yang berkaitan dengan pelaksanaan
                    perjanjian ini dibuat
                    secara
                    tertulis dan dapat disampaikan terlebih dahulu melalui faksimile pada hari dan/atau tanggal surat dengan
                    diikuti
                    konfirmasi secara tertulis kepada alamat-alamat di bawah ini:</li>

                <div class="mb-3" style="page-break-inside: avoid;">
                    <li class="fw-bold">Dinas Pemuda dan Olahraga Kota Bukittinggi</li>
                    <div class="container">
                        <table>
                            <tr>
                                <td style="width: 34%">Nama/Jabatan</td>
                                <td style="width: 1%;">:</td>
                                <td><span class="fw-bold">{{ $data->skpd?->detail?->nama_pimpinan }}</span> /
                                    {{ $data->skpd?->detail?->jabatan }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $data->skpd?->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Telp./HP</td>
                                <td>:</td>
                                <td>{{ $data->skpd?->detail?->hp_pimpinan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Surel</td>
                                <td>:</td>
                                <td>{{ $data->skpd?->detail?->email_pimpinan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <li class="fw-bold">{{ $data->lembaga?->acronym }} Kota Bukittinggi</li>

                    <div class="container">
                        <table>
                            <tr>
                                <td style="width: 34%">Nama/Jabatan</td>
                                <td style="width: 1%;">:</td>
                                <td><span class="fw-bold">{{ strtoupper($data->lembaga?->pengurus[0]?->name) }}</span> /
                                    {{ $data->lembaga?->pengurus[0]?->jabatan }}</td>
                            </tr>
                            <tr>
                                <td style="width: 34%">Alamat</td>
                                <td>:</td>
                                <td>{{ ucwords($data->lembaga?->alamat) ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Telp./HP</td>
                                <td>:</td>
                                <td>{{ $data->lembaga?->telp ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Surel</td>
                                <td>:</td>
                                <td>{{ $data->lembaga?->email ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    </d>
                    <li>Jika terjadi keterlambatan penerimaan pemberitahuan secara tertulis, maka keterlambatan tersebut
                        tidak
                        dianggap
                        sebagai suatu keterlambatan dan tetap berlaku sejak tanggal dikeluarkannya surat tersebut.</li>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 11</h6>
                <h6 class="fw-bold">BERAKHIRNYA PERJANJIAN</h6>
            </div>

            <p class="no-indent mb-3">Perjanjian ini berakhir dengan:</p>

            <ol class="no-indent mb-3">
                <li>Telah selesainya jangka waktu perjanjian sebagaimana dimaksud Pasal 3;</li>
                <li>Tercapainya tujuan pemberian hibah sebagaimana dimaksud Pasal 2 ayat (2) yang dibuktikan dengan Laporan
                    Penggunaan</li>
                <li>Pengakhiran perjanjian sebagaimana dimaksud pada pasal 9 ayat (1) dan ayat (3);</li>
                <li>pembatalan sebagaimana dimaksud pada Pasal 9 ayat (4);</li>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 12</h6>
                <h6 class="fw-bold">PENYELESAIAN PERSELISIHAN</h6>
            </div>

            <ol class="angka-kurung mb-3">

                <li>Dalam hal terjadi perselisihan akibat pelaksanaan perjanjian ini, maka para pihak sepakat langkah
                    pertama
                    akan diselesaikan secara musyawarah untuk mufakat;</li>

                <li>Apabila penyelesaian sebagaimana dimaksud ayat (1) Pasal ini tidak mencapai kesepakatan, maka
                    berdasarkan
                    kesepakatan para pihak, perselisihan diselesaikan melalui mediasi di Tingkat Pengadilan Negeri
                    Bukittinggi;
                </li>

                <li>Dalam hal penyelesaian sebagaimana dimaksud ayat (2) Pasal ini tidak disepakati oleh para pihak, maka
                    langkah selanjutnya permasalahan akan diselesaikan kedua belah pihak dengan memilih domisili tetap dan
                    umum
                    di Kantor Kepaniteraan Pengadilan Negeri Bukittinggi;</li>

                <li>Segala biaya yang timbul akibat penyelesaian perselisihan sebagaimana dimaksud ayat (1) dan ayat (2)
                    Pasal
                    ini merupakan beban para pihak yang diatur secara seimbang.</li>

            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 13</h6>
                <h6 class="fw-bold">KEADAAN KAHAR</h6>
            </div>

            <ol class="angka-kurung mb-3">
                <li>Yang dimaksud dengan keadaan kahar dalam perjanjian ini, adalah dimana terjadi suatu tindakan dan/atau
                    kejadian di
                    luar kemampuan PARA PIHAK untuk mengatasinya dan mengakibatkan tidak dapat dilaksanakannya perjanjian
                    ini,
                    seperti
                    berupa bencana alam; gempa bumi; banjir; kebakaran; kerusuhan; peristiwa lainnya di luar kekuasaan PARA
                    PIHAK
                    seperti: perang; huru-hara; pemberontakan; kerusuhan sipil; pemogokan massal; peledakan; kerusakan
                    jaringan
                    listrik;
                    kerusakan alat telekomunikasi; serangan virus/<i>software</i>; <i>epidemic</i>; perubahan peraturan
                    perundangan-undagan; dan kebijakan ekonomi moneter yang secara langsung berkaitan dengan pelaksanaan
                    perjanjian ini, yang tidak
                    disebabkan
                    atas kesalahan dan kelalaian PARA PIHAK, maka segala keterlambatan dalam memnuhi kewajiban tidak
                    dianggap
                    sebagai kesalahan sehingga tidak dapat dikenakan sanksi;</li>

                <li>Dalam hal satu pihak terkena peristiwa yang termasuk kategori keadaan kahar, maka pihak yang terkena
                    tersebut berkewajiban untuk memberitahukan peristiwa yang manimpanya kepada pihak lainnya dalam
                    perjanjian
                    ini, dengan dilampiri pernyataan dari pihak yang berwenang dalam hal itu selambat-lambatnya 14 (empat
                    belas)
                    hari kalender terhitung mulai tanggal terjadinya peristiwa tersebut;</li>

                <li>Pihak lainnya dalam Perjanjian ini yang menerima pemberitahuan sebagaimana dimaksud ayat (2) dapat
                    mempertimbangkan kelangsungan perjanjian dengan mengadakan negosiasi kembali serta mengacu kepada
                    prinsip
                    <i>win-win solution</i>;
                </li>

                <li>Semua kerugian dan biaya yang diderita oleh salah satu PIHAK sebagai akibat terjadinya keadaan kahar
                    merupakan beban dan tanggung jawab pihak yang bersangkutan.</li>
            </ol>

            <div class="w-100 mb-3 mt-4 text-center header_block">
                <h6 class="fw-bold">Pasal 14</h6>
                <h6 class="fw-bold">ADDENDUM ATAU AMANDEMEN</h6>
            </div>

            <ol class="angka-kurung mb-3">

                <li>Hal-hal yang belum cukup diatur dalam perjanjian ini dapat diatur tersendiri dalam bentuk addendum atau
                    amandemen
                    perjanjian yang merupakan bagian yang tak terpisahkan dari perjanjian ini;</li>

                <li>Setiap penambahan atau perubahan atas ketentuan yang ditetapkan dalam perjanjian ini harus atas
                    kesepakatan
                    PARA PIHAK.</li>

            </ol>

            <div style="page-break-inside: avoid;">
                <p class="no-indent mb-3">Naskah Perjanjian Hibah Daerah ini dibuat dan ditandatangani oleh PARA PIHAK dan
                    saksi-saksi di
                    Bukittinggi pada hari dan tanggal tersebut di atas dalam rangkap 2 (dua) bermaterai cukup, 1 (satu)
                    rangkap
                    untuk PIHAK PERTAMA, 1 (satu) rangkap untuk PIHAK KEDUA, dan masing-masing memiliki kekuatan hukum yang
                    sama.
                </p>

                <!-- Tanda Tangan -->
                <div class="signature-area">
                    <table class="signature-table">
                        <tr>
                            <td style="width: 50%;" class="fw-bold text-center">PIHAK KEDUA</td>
                            <td style="width: 50%;" class="fw-bold text-center">PIHAK PERTAMA</td>
                        </tr>
                        <tr>
                            <td style="height: 8rem;"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="signature-line">
                                    <strong>{{ $pimpinan_lembaga->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <div class="signature-line">
                                    <strong>{{ $data->lembaga?->skpd?->detail?->nama_pimpinan }}</strong>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div>Pimpinan {{ $data->lembaga?->name }}</div>
                            </td>
                            <td class="text-center">
                                <span class="text-wrap">{{ $data->lembaga?->skpd?->detail?->golongan_pimpinan }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">NIK. {{ $pimpinan_lembaga->nik }}</td>
                            <td class="text-center">NIP. {{ $data->lembaga?->skpd?->detail?->nip_pimpinan }}</td>
                        </tr>
                        {{-- <tr>
                            <!-- PIHAK KEDUA -->
                            <td class="signature-col" style="text-align:center;">
                                <strong>PIHAK KEDUA</strong><br>
                                {{ $data->lembaga?->name }}<br>

                                <div class="ttd-space"></div>

                                <div class="signature-line">
                                    <strong>{{ $pimpinan_lembaga->name }}</strong>
                                </div>
                                <div>Pimpinan {{ $data->lembaga?->name }}</div>
                                <div class="text-center">NIK. {{ $pimpinan_lembaga->nik }}</div>
                            </td>

                            <!-- PIHAK PERTAMA -->
                            <td class="signature-col" style="text-align:center;">
                                <strong>PIHAK PERTAMA</strong><br>
                                Pemerintah Daerah Kota Bukittinggi<br>
                                <span class="text-wrap">{{ $data->lembaga?->skpd?->name }}</span>

                                <div class="ttd-space"></div>

                                <div class="signature-line">
                                    <strong>{{ $data->lembaga?->skpd?->detail?->nama_pimpinan }}</strong>
                                </div>
                                <div><span
                                        class="text-wrap">{{ $data->lembaga?->skpd?->detail?->golongan_pimpinan }}</span>
                                </div>
                                <div class="text-center">NIP. {{ $data->lembaga?->skpd?->detail?->nip_pimpinan }}</div>
                            </td>
                        </tr> --}}
                    </table>
                </div>
            </div>
            <div class="w-100 mb-3 mt-4 text-center">
                <Span class="mb-3 fw-bold">Saksi-saksi</Span>
            </div>
            <table class="w-100">
                <tr>
                    <td style="width: 15px; height: 50px; padding-bottom: 4rem;">1</td>
                    <td style="width: 75%;">{{ $data->lembaga?->skpd?->detail?->nama_sekretaris }}<br>Sekretaris
                        {{ $data->lembaga?->skpd?->name }}<br></td>
                    <td>1</td>
                </tr>
                <tr>
                    <td style="width: 15px; height: 50px; padding-bottom: 4rem;">2</td>
                    <td>{{ $data->lembaga?->urusan?->kepala_urusan }}<br>Kepala Bidang
                        {{ $data->lembaga?->urusan?->nama_urusan }} pada {{ $data->lembaga?->skpd?->name }}<br></td>
                    <td>2</td>
                </tr>
                <tr>
                    <td style="width: 15px; height: 50px; padding-bottom: 4rem;">3</td>
                    <td>{{ $data->lembaga?->pengurus[1]?->name }}<br>Sekretaris {{ $data->lembaga?->name }}<br></td>
                    <td>3</td>
                </tr>
                <tr>
                    <td style="width: 15px; height: 50px; padding-bottom: 4rem;">4</td>
                    <td>{{ $data->lembaga?->pengurus[2]?->name }}<br>Bendahara {{ $data->lembaga?->name }}<br></td>
                    <td>4</td>
                </tr>
            </table>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <table style="width: 100%;">
                <tr style="font-size: 10.5px">
                    <td style="font-size: 11px;" rowspan="2">NPHD antara Pemko Bukittinggi dengan
                        {{ $data->lembaga?->acronym }} Kota
                        Bukittinggi Tahun
                        {{ $data->tahun_apbd }}</td>
                    <td style="width: 100px; border-width: 1px 1px 1px 1px; border-color:black; border-style:solid;">Paraf
                        Pihak Pertama</td>
                    <td style="width: 50px; border-width: 1px 1px 1px 1px; border-color:black; border-style:solid;"></td>
                </tr>
                <tr style="font-size: 10.5px">
                    <td style="border-width: 0px 1px 1px 1px; border-color:black; border-style:solid;">Paraf Pihak Kedua
                    </td>
                    <td style="border-width: 0px 1px 1px 1px; border-color:black; border-style:solid;"></td>
                </tr>
            </table>
            {{-- <div class="row">
            <div class="col-8">
                NPHD antara Pemko Bukittinggi dengan {{ $data->lembaga?->acronym }} Kota Bukittinggi Tahun
                {{ $data->tahun_apbd }}
            </div>
            <div class="col-4">
                <table style="border: 1px black solid">
                    <tr style="border-bottom: 1px black solid">
                        <td>Paraf Pihak Pertama</td>
                        <td class="signature"></td>
                    </tr>
                    <tr>
                        <td>Paraf Pihak Kedua</td>
                        <td class="signature"></td>
                    </tr>
                </table>
            </div>
        </div> --}}
        </div>
    </footer>

    {{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> --}}
@endsection
