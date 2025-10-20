@extends('pdf._app')

@push('style')
    <style>
        @page {
            size: 215mm 330mm;
            margin: 18mm;
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
            text-indent: -1.55em;
            padding-left: 1.75em;
            text-align: justify;
            list-style: none;
        }

        ol>li::before {
            content: counter(num) ". ";
            display: inline-block;
            width: 2ch;
            margin-right: .6rem;
            text-align: right;
        }

        ol.angka-kurung {
            counter-reset: num;
            list-style: none;
            padding-left: 2em;
        }

        ol.angka-kurung>li {
            counter-increment: num;
            text-indent: -1.55em;
            padding-left: 1.75em;
            text-align: justify;
            list-style: none;
        }

        ol.angka-kurung>li::before {
            content: "(" counter(num) ") ";
            display: inline-block;
            width: 2ch;
            margin-right: .6rem;
            text-align: right;
        }

        ol.alpha {
            counter-reset: alpha;
            list-style: none;
            padding-left: 2em;
        }

        ol.alpha>li {
            counter-increment: alpha;
            text-indent: -1.55em;
            padding-left: 1.75em;
            text-align: justify;
            list-style: none;
        }

        ol.alpha>li::before {
            content: counter(alpha, lower-alpha) ". ";
            display: inline-block;
            width: 2ch;
            margin-right: .6rem;
            text-align: right;
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
    </style>
@endpush

@section('pdf-content')
    <div class="container-fluid">
        <!-- Judul Utama -->
        <div class="judul-utama mb-1">
            NASKAH PERJANJIAN HIBAH DAERAH DALAM BENTUK UANG
        </div>
        <div class="judul-utama mb-1">
            PERJANJIAN
        </div>
        <div class="judul-utama mb-1">
            ANTARA
        </div>
        <div class="judul-utama mb-1">
            PEMERINTAH DAERAH KOTA BUKITTINGGI
        </div>
        <div class="judul-utama mb-1">
            DAN
        </div>
        <div class="judul-utama mb-1">
            PENERIMA HIBAH
        </div>

        <!-- Nomor Surat -->
        <div class="nomor-surat">
            Nomor: ...................
        </div>

        <!-- Para Pihak -->
        <div class="mb-4">
            <p class="paragraph-indent">
                Pada hari ini, ..............., tanggal ..... bulan ...... Tahun ......, yang bertanda tangan di bawah ini:
            </p>

            <table class="table">
                <tr class="pb-3">
                    <td class="text-end" style="width:3%;">I</td>
                    <td style="width: 37%"></td>
                    <td style="width: 60%;"><span class="fw-bold">NIP. ..................................</span> selaku
                        <span class="fw-bold">Kepala
                            Bidang {{ $data->lembaga?->urusan?->nama_urusan }}</span> dalam hal ini bertindak untuk dan atas
                        nama
                        <span class="fw-bold">{{ $data?->lembaga?->skpd?->name }}</span> selanjutnya disebut <span
                            class="fw-bold">PIHAK PERTAMA</span>
                    </td>
                </tr>
                <tr>
                    <td class="text-end">II</td>
                    <td class="fw-bold">{{ $pimpinan_lembaga->name }}
                    </td>
                    <td><span class="fw-bold justify-content">NIK. {{ $pimpinan_lembaga->nik }}</span> yang beralamat di
                        {{ $pimpinan_lembaga->alamat }}. Dalam hal ini bertindak sebagai {{ $pimpinan_lembaga->jabatan }}
                        {{ $data->lembaga?->name }} Selanjutnya disebut <span class="fw-bold">PIHAK KEDUA.</span></td>
                </tr>
            </table>
        </div>

        <p class="no-indent mb-3">PIHAK PERTAMA DAN PIHAK KEDUA selanjutnya secara bersama-sama disebut sebagai PARA PIHAK,
            dan
            secara sendiri-sendiri disebuk PIHAK:</p>
        <ol class="mb-3">
            <li>
                PIHAK PERTAMA adalah Satuan Kerja Perangkat Daerah yang dibentuk berdasarkan Peraturan Daerah Kota
                Bukittinggi Nomor 4 Tahun 2022 tentang Perubahan. Atas Peraturan Daerah Kota Bukittinggi Nomor 09 Tahun 2015
                tentang Pembentukan dan Susunan Perangkat Daerah yang turunannya berupa Peraturan Wali Kota Bukittinggi
                Nomor 42 Tahun 2022 tentang Kedudukan, Susunan Organisasi, Tugas dan Fungsi Serta Tata Kerja Dinas Pemuda
                dan Olahraga;</li>
            <li>PIHAK PERTAMA sebagai penyelenggara sebagian urusan pemerintahan daerah menurut asas otonomi dengan
                kewenangan, hak dan kewajiban untuk mengatur serta mengurus sendiri urusan pemerintahan dan kepentingan
                masyarakat setempat di bidang olahraga sesuai ketentuan peraturan perundang-undangan;</li>
            <li>PIHAK KEDUA adalah pimpinan {{ ucwords($data->lembaga?->name) }} ({{ $data->lembaga?->acronym }}) Kota
                Bukittinggi selaku
                penyelenggara dan pembina langsung olahraga prestasi di Kota Bukittinggi sebagaimana dimaksud dalam Surat
                Keputusan Ketua KONI Provinsi Sumatera Barat Nomor : 064 Tahun 2025 Tanggal 5 Februari 2025.</li>
        </ol>
        <p class="no-indent mb-3">PIHAK PERTAMA dan PIHAK KEDUA dengan mendasarkan dan memperhatikan hal sebagai berikut:
        </p>
        <ol class="mb-5">
            <li>Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah sebagaimana telah diubah beberapa kali,
                terakhir dengan Undang-Undang Nomor 11 Tahun 2020 tentang Cipta Kerja;</li>
            <li>Undang-Undang Republik Indonesia Nomor 11 Tahun 2022 tentang Keolahragaan;</li>
            <li>Peraturan Pemerintah Nomor 12 Tahun 2019 tentang Pengelolaan Keuangan Daerah;</li>
            <li>Peraturan Menteri Dalam Negeri Nomor 90 Tahun 2019 tentang Perubahan Kelima Atas Peraturan Menteri Dalam
                Negeri Nomor 32 Tahun 2011 tentang Pedoman Pemberian Hibah dan Bantuan Sosial yang Bersumber Dari Anggaran
                Pendapatan dan Belanja Daerah;</li>
            <li>Peraturan Menteri Dalam Negeri Nomor 77 Tahun 2020 tentang Pedoman Teknis Pengelolaan Keuangan Daerah;</li>
            <li>Peraturan Wali Kota Bukittinggi Nomor 11 Tahun 2021 tentang Pedoman dan Prosedur Pemberian Hibah dan Bantuan
                Sosial;</li>
            <li>Keputusan Wali Kota Bukittinggi Nomor 188.45-51-2025 tanggal 1 Maret 2025 tentang Penerima dan Besaran Hibah
                Berupa Uang Pada Dinas Pemuda dan Olahraga Tahun Anggaran 2025;</li>
            <li>Surat Ketua Umum KONI Kota Bukittinggi yang ditujukan kepada Walikota Bukittinggi Cq. Dinas Pemuda dan
                Olahraga (DISPORA) Nomor : 003/KU/KONI-BKT/III/2025 Tanggal 10 Maret 2025 perihal Mohon Pencairan Dana Hibah
                Tahun 2025;.</li>
            <li>Rincian Anggaran Biaya (RAB) KONI Kota Bukittinggi Tahun 2025 yang menjadi bagian pelaksanaan program dan
                kegiatan KONI Kota Bukittinggi Tahun Anggaran 2025;</li>
            <li>Pakta Integritas dari KONI Kota Bukittinggi.</li>
        </ol>

        <p class="no-indent mb-3">Dengan ini sepakat untuk melaksanakan Perjanjian Hibah Daerah, dengan ketentuan dan
            syarat-syarat sebagai berikut:</p>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 1</h6>
            <h6>OBJEK PERJANJIAN</h6>
        </div>

        <p class="no-indent mb-3">PIHAK PERTAMA menyerahkan Hibah Berupa Uang kepada PIHAK KEDUA dan PIHAK KEDUA menerima
            Hibah Berupa Uang dari PIHAK PERTAMA sebesar:<br>
            Rp. {{ number_format($nominal_anggaran, 0, ',', '.') }},-
            ({{ strtolower(App\Helpers\General::Terbilang($nominal_anggaran)) }} rupiah).</p>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 2</h6>
            <h6>Ruang Lingkup</h6>
        </div>

        <ol class="mb-3 angka-kurung">
            <li>Hibah sebagaimana dimaksud Pasal 1 ini adalah dana yang telah dianggarkan dalam Anggaran Pendapatan dan
                Belanja Daerah Kota Bukittinggi Tahun Anggaran 2025 Rekening Nomor 5.2.19.0.00.0006. 5.1.05.05.01.0001, Sub
                Kegiatan Penyelenggaraan Kerja Sama Organisasi Keolahragaan Daerah, dengan kode rekening belanja hibah
                berupa uang.</li>
            <li>Dana hibah sebagaimana dimaksud pada ayat (1) dipergunakan untuk kegiatan KONI Kota Bukittinggi Tahun
                Anggaran 2025 sesuai dengan Rincian Anggaran Biaya Pelaksanaan Program dan Kegiatan Tahun Anggaran 2025 yang
                menjadi bagian yang tidak terpisahkan dari Naskah Perjanjian Hibah Daerah ini.</li>
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 3</h6>
            <h6>JANGKA WAKTU</h6>
        </div>

        <p class="no-indent mb-3">
            Perjanjian ini berlaku terhitung sejak Naskah Perjanjian Hibah Daerah ini ditandatangani sampai dengan tanggal
            {{ App\Helpers\General::getIndoDate($data->akhir_laksana) }}.
        </p>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 4</h6>
            <h6>PENYERAHAN DANA HIBAH</h6>
        </div>

        <ol>
            <li>Sebelum bantuan hibah diserahkan kepada PIHAK KEDUA, terlebih dahulu PIHAK PERTAMA meminta Pakta Integritas
                terkait dengan penggunaan hibah dan nomor rekening tersendiri atas nama Dana Hibah KONI Kota Bukittinggi,
                sehingga hibah terpisah dari keuangan KONI Kota Bukittinggi lainnya.</li>
            <li>Penyerahan hibah dilakukan secara sekaligus sebesar Rp.
                {{ number_format($nominal_anggaran, 0, ',', '.') }},-
                ({{ strtolower(App\Helpers\General::Terbilang($nominal_anggaran)) }} rupiah).</li>
            <li>Penyerahan hibah dibuktikan dengan Berita Acara Serah Terima Hibah yang ditandatangani oleh PIHAK PERTAMA
                dan PIHAK KEDUA.</li>
            <li>Bahwa selama penempatan dana hibah pada bank yang ditunjuk, PIHAK KEDUA belum mempergunakan dana hibah
                tersebut untuk tujuan sebagaimana dimaksud Pasal 2 ayat (2) perjanjian ini maka seluruh bunga atau hasil
                yang ditimbulkan dari penempatan tersebut merupakan satu kesatuan dari dana hibah dimaksud.
            </li>
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 5</h6>
            <h6>LAPORAN PENGGUNAAN DANA HIBAH</h6>
        </div>

        <ol class="angka-kurung mb-3">
            <li>Dalam penggunaan hibah PIHAK KEDUA membuat Laporan Penggunaan Hibah dan menyerahkannya kepada PIHAK PERTAMA.
            </li>
            <li>Laporan penggunaan hibah sebagaimana dimaksud ayat (1) diberikan oleh PIHAK KEDUA kepada PIHAK PERTAMA
                dengan melampirkan:</li>
            <ol class="alpha">

                <li>Laporan pelaksanaan Program dan Kegiatan KONI Kota Bukittinggi Tahun Anggaran {{ $data->tahun_apbd }};
                </li>
                <li>Laporan keuangan atau realisasi penggunaan dana hibah;</li>
                <li>Foto copy keadaan rekening terakhir (saat Laporan Penggunaan Hibah diajukan);</li>
                <li>Laporan realisasi fisik;</li>
                <li>Surat pernyataan tanggung jawab, yang menyatakan bahwa hibah yang telah diterima, telah digunakan sesuai
                    peruntukan yang telah disepakati;</li>
                <li>Surat Tanda Setoran (STS) ke Kas Daerah Kota Bukittinggi atas sisa dana hibah dan/atau bunga yang
                    diperoleh dari penggunaan rekening hibah.</li>
            </ol>

            <li>Laporan Penggunaan Hibah sebagaimana dimaksud ayat (2) disampaikan oleh PIHAK KEDUA paling lambat tanggal 7
                Januari
                {{ $data->tahun_apbd + 1 }}.</li>

            <li>Berdasarkan Laporan Penggunaan Hibah PIHAK KEDUA beserta lampiran sebagaimana tersebut pada ayat (2) maka
                PIHAK
                PERTAMA dapat melakukan evaluasi terhadap penggunaan hibah dengan mengacu pada ketentuan perundang-undangan
                yang
                berlaku.</li>

            <li>Berdasarkan hasil evaluasi sebagaimana dimaksud pada ayat (4), dapat juga dilakukan pada waktu lain yang
                dianggap
                perlu oleh PIHAK PERTAMA.</li>

            <li>Apabila hasil evaluasi sebagaimana dimaksud pada ayat (5), PIHAK PERTAMA dapat melaksanakan pengawasan dan
                pemeriksaan sesuai dengan ketentuan yang berlaku.
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 6</h6>
            <h6>HAK DAN KEWAJIBAN</h6>
        </div>

        <ol class="angka-kurung">
            <li> Hak PIHAK PERTAMA :</li>
            <ol class="alpha">
                <li>Meminta nomor rekening tersendiri sebagaimana dimaksud Pasal 4 ayat (1);</li>
                <li>Meminta kelengkapan yang dibutuhkan dalam rangka proses monitoring dan evaluasi yang dilaksanakan oleh
                    PIHAK
                    PERTAMA terkait dengan penggunaan dana hibah daerah;</li>
                <li>Menerima laporan penggunaan dana hibah beserta lampirannya dari PIHAK KEDUA sebagaimana dimaksud Pasal
                    5;</li>
                <li>Menerima pengembalian sisa dana hibah dan/atau bunga yang timbul dari penempatan dana hibah di rekening;
                </li>
                <li>Menunjuk auditor dalam melakukan audit terhadap penggunaan hibah sebagaimana dimaksud Pasal 5 ayat (4);
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
                <li>Menyerahkan dana hibah kepada PIHAK KEDUA sebagaimana dimaksud pada Pasal 4, apabila seluruh persyaratan
                    dan
                    kelengkapan berkas pengajuan hibah telah dipenuhi oleh PIHAK KEDUA dan dinyatakan lengkap dan benar oleh
                    PIHAK
                    PERTAMA;</li>
                <li>Secara bersama-sama dengan PIHAK KEDUA menandatangani Berita Acara Serah Terima Hibah sebagaimana
                    dimaksud
                    Pasal 4 ayat (3);</li>
                <li>Melakukan audit sebagaimana dimaksud pada Pasal 5 ayat (4) dan (5).</li>
            </ol>
            <li>Hak PIHAK KEDUA :</li>
            <ol class="alpha">
                <li> Menerima penyerahan dana hibah dari PIHAK PERTAMA sebagaimana dimaksud pada Pasal 4, apabila
                    seluruh
                    persyaratan dan kelengkapan berkas pengajuan dana hibah telah dipenuhi oleh PIHAK KEDUA dan
                    dinyatakan lengkap
                    dan benar oleh PIHAK PERTAMA;</li>
                <li>Menggunakan dana hibah sebagaimana dimaksud pada Pasal 2 ayat (2).</li>
            </ol>
            <li>Kewajiban PIHAK KEDUA :</li>
            <ol class="alpha">
                <li>Mempergunakan dana hibah sesuai dengan tujuan pemberian hibah sebagaimana dimaksud dalam Pasal 2 ayat
                    (2)
                    yang disesuaikan dengan Rincian Anggaran Biaya (RAB) Pelaksanaan Program dan Kegiatan KONI Kota
                    Bukittinggi
                    Tahun Anggaran 2025 (Rincian Anggaran Biaya tersebut merupakan satu kesatuan yang tak terpisahkan dengan
                    Perjanjian ini);</li>
                <li>Menandatangani Pakta Integritas yang menyatakan bahwa hibah yang diterima akan dipergunakan sesuai
                    dengan
                    perjanjian hibah ini;</li>
                <li>Melaksanakan dan bertanggung jawab penuh secara formal dan material atas penggunaan hibah untuk KONI
                    Kota
                    Bukittinggi yang bersumber dari dana hibah daerah dan telah disetujui PIHAK PERTAMA dengan berpedoman
                    pada
                    ketentuan perundang-undangan yang berlaku;</li>
                <li>Menandatangani serta menyerahkan kepada PIHAK PERTAMA Surat Pernyataan Tanggung Jawab yang menyatakan
                    bahwa hibah yang diterima telah digunakan sesuai perjanjian hibah ini paling lambat tanggal 10 Januari
                    2026;</li>
                <li> Menyediakan kelengkapan yang dibutuhkan dalam rangka proses monitoring dan evaluasi yang dilaksanakan
                    oleh PIHAK PERTAMA terkait dengan penggunaan dana hibah daerah;</li>
                <li>Melaksanakan pengadaan barang/jasa dengan berpedoman kepada Rencana Anggaran Biaya (RAB) yang telah
                    diverifikasi dan disahkan oleh Satuan Kerja Perangkat Daerah (SKPD) teknis terkait;</li>
                <li>Menyetor sisa dana hibah/bunga yang ditimbulkan dari penempatan dana hibah di rekening bank kepada PIHAK
                    PERTAMA, dalam rangka optimalisasi program dan kegiatan KONI Kota Bukittinggi Tahun Anggaran 2025 telah
                    diselesaikan;</li>
                <li>Menjaga dan mempergunakan bukti-bukti pengeluaran yang lengkap dan sah sesuai peraturan
                    perundang-undangan dalam rangka PIHAK KEDUA selaku obyek pemeriksaan;</li>
                <li>Membuat dan memberikan Laporan Penggunaan Hibah kepada PIHAK PERTAMA sebagaimana dimaksud Pasal 5
                    perjanjian ini, paling lambat tanggal 10 Januari 2026.</li>
            </ol>
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 7</h6>
            <h6>KETENTUAN PAJAK</h6>
        </div>

        <p class="no-indent">Segala ketentuan pajak yang timbul akibat pelaksanaan perjanjian ini, ditanggung oleh KONI Kota
            Bukittinggi sesuai
            dengan ketentuan peraturan perundang-undangan.</p>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 8</h6>
            <h6>WANPRESTASI</h6>
        </div>

        <ol class="angka-kurung">


            <li>Wanprestasi adalah apabila PIHAK PERTAMA atau PIHAK KEDUA tidak memenuhi atau lalai melaksanakan
                kewajibannya
                sebagaimana yang dimaksud pada Pasal 6 ayat (2) dan ayat (4). Perjanjian ini akan diselesaikan yang diatur
                dalam
                Buku III Kitab Undang-undang Hukum Perdata;</li>

            <li>Apabila salah satu pihak terbukti melakukan wanprestasi, maka pihak lainnya dalam perjanjian ini dapat
                mengenakan
                sanksi dengan terlebih dahulu memberikan peringatan/teguran tertulis kepada pihak yang wanprestasi minimal
                sebanyak
                3 (tiga) kali dengan jarak waktu masing-masing 1 (satu) minggu.</li>
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 9</h6>
            <h6>SANKSI</h6>
        </div>

        <ol class="angka-kurung">

            <li>Dalam hal PIHAK PERTAMA setelah melakukan monitoring dan evaluasi terhadap pemberian hibah sebagaimana
                dimaksud pada
                Pasal 6 (ayat 1) huruf “b”, “d”, “e” dan “g” berkesimpulan bahwa hibah yang telah diberikan tidak sesuai
                dengan
                tujuan penggunaan sebagaimana dimaksud pada Pasal 2 ayat (2), atau laporan yang disampaikan PIHAK KEDUA
                ditemukan
                ada penyimpangan dari perjanjian ini, maka PIHAK PERTAMA dan/atau PIHAK PERTAMA berwenang menjatuhkan sanksi
                sebagai
                berikut:</li>
            <ol class="alpha">


                <li>Meminta PIHAK KEDUA untuk mengembalikan sebagian atau seluruh dana hibah sebagaimana dimaksud Pasal 6
                    ayat (d),
                    maka kepada PIHAK KEDUA dapat diberikan sanksi administratif;</li>
                <li>Memberikan peringatan tertulis kepada PIHAK KEDUA;</li>
                <li>PIHAK KEDUA tidak berhak lagi mengajukan permohonan hibah daerah pada periode anggaran berikutnya.</li>
            </ol>

            <li>Apabila pengembalian hibah oleh KONI Pemerintah Kota Bukittinggi berupa pengembalian dana hibah yang
                digunakan tidak
                sesuai dengan tujuan peruntukan hibah:</li>

            <li>Dapat dilakukan melalui mekanisme penagihan oleh Pejabat Pengelola Keuangan Daerah (PPKD);</li>
            <li>Dapat ditempuh melalui mekanisme penyelesaian hukum.</li>
            <li>Dalam hal PIHAK KEDUA tidak melaksanakan program dan kegiatan KONI Kota Bukittinggi sebagaimana dimaksud
                Pasal 2 ayat (2), maka PIHAK KEDUA dikenakan sanksi berupa pengembalian seluruh dana hibah yang diberikan
                beserta bunga yang ditimbulkan atas penempatan dana hibah pada rekening. PIHAK KEDUA dan/atau PIHAK PERTAMA
                dapat membatalkan perjanjian secara sepihak.</li>
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 10</h6>
            <h6>PEMBERITAHUAN DAN KORESPONDENSI</h6>
        </div>

        <ol class="angka-kurung">
            <li>Segala macam pemberitahuan dan surat-menyurat yang berkaitan dengan pelaksanaan perjanjian ini dibuat secara
                tertulis dan dapat disampaikan terlebih dahulu melalui faksimile pada hari dan/atau tanggal surat dengan
                diikuti
                konfirmasi secara tertulis kepada alamat-alamat di bawah ini:</li>

            <ol class="a">
                <li class="fw-bold">Dinas Pemuda dan Olahraga Kota Bukittinggi</li>
                <div class="container">
                    <table>
                        <tr>
                            <td style="width: 34%">Nama/Jabatan</td>
                            <td style="width: 1%;">:</td>
                            <td>NENTA OKTAVIA, S.STP, MPA. / Kepala Dinas</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>Jl. Cindua Mato No. 7, Kel. Benteng Pasar Atas, Kec. Guguk Panjang, Kota Bukittinggi</td>
                        </tr>
                        <tr>
                            <td>Telp./HP</td>
                            <td>:</td>
                            <td>0811 661 712</td>
                        </tr>
                        <tr>
                            <td>Surel</td>
                            <td>:</td>
                            <td>-</td>
                        </tr>
                    </table>
                </div>
                <li class="fw-bold">KONI Kota Bukittinggi</li>

                <div class="container">
                    <table>
                        <tr>
                            <td style="width: 34%">Nama/Jabatan</td>
                            <td style="width: 1%;">:</td>
                            <td>HENDRA HENDARMAN / Ketua Umum</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td>Jl. Dr. A. Rivai No. 17A, Bukit Apit Puhun, Guguk Panjang, Bukittinggi, Sumatera Barat</td>
                        </tr>
                        <tr>
                            <td>Telp./HP</td>
                            <td>:</td>
                            <td>0812 8227 6909</td>
                        </tr>
                        <tr>
                            <td>Surel</td>
                            <td>:</td>
                            <td>konibukittinggi99@gmail.com</td>
                        </tr>
                    </table>
                </div>
            </ol>
            <li>Jika terjadi keterlambatan penerimaan pemberitahuan secara tertulis, maka keterlambatan tersebut tidak
                dianggap
                sebagai suatu keterlambatan dan tetap berlaku sejak tanggal dikeluarkannya surat tersebut.</li>
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 11</h6>
            <h6>BERAKHIRNYA PERJANJIAN</h6>
        </div>

        <p class="no-indent">Perjanjian ini berakhir dengan:</p>

        <ol>
            <li>Telah selesainya jangka waktu perjanjian sebagaimana dimaksud Pasal 3;</li>
            <li>Tercapainya tujuan pemberian hibah sebagaimana dimaksud Pasal 2 ayat (2) yang dibuktikan dengan Laporan
                Penggunaan</li>
            <li>Hibah serta Surat Pernyataan Tanggung Jawab dari PIHAK KEDUA yang menyatakan bahwa hibah yang diterima telah
                digunakan sesuai perjanjian hibah ini;</li>

            <li>Adanya pembatalan perjanjian sebagaimana dimaksud pada Pasal 9 ayat (1) dan ayat (3);</li>

            <li>Pembatalan sebagaimana dimaksud pada Pasal 9 ayat (4).</li>
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 12</h6>
            <h6>PENYELESAIAN PERSELISIHAN</h6>
        </div>

        <ol class="angka-kurung">

            <li>Dalam hal terjadi perselisihan akibat pelaksanaan perjanjian ini, maka para pihak sepakat langkah pertama
                akan diselesaikan secara musyawarah untuk mufakat;</li>

            <li>Apabila penyelesaian sebagaimana dimaksud ayat (1) Pasal ini tidak mencapai kesepakatan, maka berdasarkan
                kesepakatan para pihak, perselisihan diselesaikan melalui mediasi di Tingkat Pengadilan Negeri Bukittinggi;
            </li>

            <li>Dalam hal penyelesaian sebagaimana dimaksud ayat (2) Pasal ini tidak disepakati oleh para pihak, maka
                langkah selanjutnya permasalahan akan diselesaikan kedua belah pihak dengan memilih domisili tetap dan umum
                di Kantor Kepaniteraan Pengadilan Negeri Bukittinggi;</li>

            <li>Segala biaya yang timbul akibat penyelesaian perselisihan sebagaimana dimaksud ayat (1) dan ayat (2) Pasal
                ini merupakan beban para pihak yang diatur secara seimbang.</li>

        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 13</h6>
            <h6>KEADAAN KAHAR</h6>
        </div>

        <ol class="angka-kurung">
            <li>Yang dimaksud dengan keadaan kahar dalam perjanjian ini, adalah dimana terjadi suatu tindakan dan/atau
                kejadian di
                luar kemampuan PARA PIHAK untuk mengatasinya dan mengakibatkan tidak dapat dilaksanakannya perjanjian ini,
                seperti
                berupa bencana alam; gempa bumi; banjir; kebakaran; kerusuhan; peristiwa lainnya di luar kekuasaan PARA
                PIHAK
                seperti: perang; huru-hara; pemberontakan; kerusuhan sipil; pemogokan massal; peledakan; kerusakan jaringan
                listrik;
                kerusakan alat telekomunikasi; serangan virus/software; embargo; serta kebijakan Pemerintah Republik
                Indonesia di
                bidang keuangan/moneter yang secara langsung berhubungan dengan pelaksanaan perjanjian ini, yang tidak
                disebabkan
                atas kesalahan dan kelalaian PARA PIHAK, maka keadaan tersebut dikategorikan keadaan kahar yang dibuktikan
                oleh
                pejabat/instansi yang berwenang sehingga tidak dapat dilaksanakan perjanjian ini.</li>

            <li>Dalam hal terjadi keadaan kahar sebagaimana dimaksud ayat (1) Pasal ini dan berakibat terhambatnya
                terlaksana
                perikatan yang dituangkan untuk memenuhi kewajiban atau kepentingan yang menimpa kedua pihak lainnya
                sehingga
                pelaksanaan perjanjian ini tidak terlaksana, maka pelaksanaan perjanjian ini ditangguhkan selama 14 (empat
                belas)
                hari kalender terhitung sejak terjadinya peristiwa tersebut.</li>

            <li>Pihak lainnya dalam Perjanjian ini yang tidak mengalami keadaan kahar sebagaimana dimaksud ayat (2) dapat
                mempertimbangkan kelanjutan perjanjian ini atau melakukan renegosiasi kembali serta mengacu kepada peraturan
                perundang-undangan yang berlaku.</li>

            <li>Apabila kerugian atau kerusakan yang diderita oleh salah satu PIHAK sebagai akibat terjadinya keadaan kahar
                sebagaimana dimaksud ayat (1) dianggap sangat merugikan, perjanjian ini dapat dibatalkan.</li>
        </ol>

        <div class="w-100 mb-3 text-center">
            <h6>Pasal 14</h6>
            <h6>ADDENDUM ATAU AMANDEMEN</h6>
        </div>

        <ol class="angka-kurung">

            <li>Hal-hal yang belum cukup diatur dalam perjanjian ini dapat diatur tersendiri dalam bentuk addendum atau
                amandemen
                perjanjian yang merupakan bagian yang tak terpisahkan dari perjanjian ini;</li>

            <li>Setiap penambahan atau perubahan atas ketentuan yang ditetapkan dalam perjanjian ini harus atas kesepakatan
                PARA PIHAK.</li>

        </ol>

        <div class="page-break"></div>

        <p class="no-indent">Naskah Perjanjian Hibah Daerah ini dibuat dan ditandatangani oleh PARA PIHAK dan saksi-saksi di
            Bukittinggi pada hari dan tanggal tersebut di atas dalam rangkap 2 (dua) bermaterai cukup, 1 (satu) rangkap
            untuk PIHAK PERTAMA, 1 (satu) rangkap untuk PIHAK KEDUA, dan masing-masing memiliki kekuatan hukum yang sama.
        </p>

        <!-- Tanda Tangan -->
        <div class="signature-area">
            <table class="signature-table">
                <tr>
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
                            <strong></strong>
                        </div>
                        <div><span class="text-wrap">Kepala Bidang {{ $data->lembaga?->urusan?->nama_urusan }}</span>
                        </div>
                        <div class="text-center">NIP </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script> --}}
@endsection
