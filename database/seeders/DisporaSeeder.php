<?php

namespace Database\Seeders;

use App\Models\Skpd;
use App\Models\SkpdDetail;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisporaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skpd = Skpd::create([
            'name' => 'Dinas Pemuda dan Olahraga',
            'deskripsi' => '',
            'alamat' => 'Jl. Cindua Mato no.7 Kel. Benteng Pasar Atas Kec. Guguk Panjang Kota Bukittinggi',
            'telp' => '',
            'email' => '',
            'fax' => '',
        ]);

        $skpd_detail = SkpdDetail::create([
            'id_skpd' => $skpd->id,
            'nama_pimpinan' => 'NENTA OKTAVIANI, S.STP, MPA',
            'jabatan_pimpinan' => 'Kepala',
            'nip_pimpinan' => '197810301998022001',
            'golongan_pimpinan' => 'Pembina Utama Muda - IV/c',
            'alamat_pimpinan' => 'Jl. Cindua Mato no.7 Kel. Benteng Pasar Atas Kec. Guguk Panjang Kota Bukittinggi',
            'hp_pimpinan' => null,
            'email_pimpinan' => null,
            'nama_sekretaris' => 'Devi Yarman, S.Sos, M.Ap',
            'jabatan_sekretaris' => 'Sekretaris',
            'nip_sekretaris' => null,
            'golongan_sekretaris' => null,
            'alamat_sekretaris' => null,
            'hp_sekretaris' => null,
            'email_sekretaris' => null,
            'perhatian_nphd' => '[{"uraian":"Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah sebagaimana telah diubah beberapa kali, terakhir dengan Undang-Undang Nomor 1 Tahun 2020 tentang Cipta Kerja","urusan":0},{"uraian":"Undang-Undang Nomor 23 Tahun 2014 tentang Pemerintahan Daerah sebagaimana telah diubah beberapa kali, terakhir dengan Undang-Undang Nomor 1 Tahun 2020 tentang Cipta Kerja","urusan":0},{"uraian":"Peraturan Pemerintah Nomor 12 Tahun 2019 tentang Pengelolaan Keuangan Daerah","urusan":0},{"uraian":"Peraturan Menteri Dalam Negeri Nomor 90 Tahun 2019 tentang Perubahan Kelima Atas Peraturan Menteri Dalam Negeri Nomor 32 Tahun 2011 tentang Pedoman Pemberian Hibah dan Bantuan Sosial yang Bersumber dari Anggaran Pendapatan dan Belanja Daerah","urusan":0},{"uraian":"Peraturan Menteri Dalam Negeri Nomor 77 Tahun 2020 tentang Pedoman Teknis Pengelolaan Keuangan Daerah","urusan":0},{"uraian":"Peraturan Wali Kota Bukittinggi Nomor 11 Tahun 2021 tentang Pedoman dan Prosedur Pemberian Hibah dan Bantuan Sosial","urusan":0},{"uraian":"Keputusan Wali Kota Bukittinggi Nomor 188.45-51-2025 tanggal 1 Maret 2025 Tentang Penerima dan Besaran Hibah Berupa Uang Pada Dinas Pemuda dan Olahraga Tahun Anggaran 2025","urusan":0}]',
            'rekening_anggaran' => '',
        ]);

        $urusan_olahraga = $skpd->has_urusan()->create([
            'id_skpd' => $skpd->id,
            'nama_urusan' => 'Olahraga',
            'nama_Kepala' => 'Siti Mariah S.Sos',
            'kegiatan' => '[{"nama_kegiatan":"Pembinaan dan Pengembangan Organisasi Olahraga","sub_kegiatan":[{"nama_sub_kegiatan":"Peningkatan Kerja Sama Organisasi Keolahragaan Kabupaten\/Kota dengan Lembaga Terkait","rekening_anggaran":[{"rekening":"2.19.03.2.04.0006"},{"rekening":"5.1.05.05.01.0001"}]}]}]',
        ]);

        $urusan_pemuda = $skpd->has_urusan()->create([
            'id_skpd' => $skpd->id,
            'nama_urusan' => 'Pemuda',
            'nama_Kepala' => 'ROMARIO PUTRA, S.STP',
            'kegiatan' => '[{"nama_kegiatan":"","sub_kegiatan":[{"nama_sub_kegiatan":"","rekening_anggaran":[{"rekening":""}]}]}]',
        ]);

        $verifikator_olahraga = User::create([
            'name' => 'Verifikator Olahraga',
            'email' => 'verifikator.olahraga@disopra.com',
            'password' => bcrypt('olga1q2w3e'),
            'id_skpd' => $skpd->id,
            'id_urusan' => $urusan_olahraga->id,
            'id_role' => 3,
        ])->assignRole('Verifikator');

        $reviewer_olahraga = User::create([
            'name' => 'Reviewer Olahraga Disopra',
            'email' => 'reviewer.olahraga@disopra.com',
            'password' => bcrypt('olga1q2w3e'),
            'id_skpd' => $skpd->id,
            'id_urusan' => $urusan_olahraga->id,
            'id_role' => 4,
        ])->assignRole('Reviewer');

        $verifikator_pemuda = User::create([
            'name' => 'Verifikator Pemuda',
            'email' => 'verifikator.pemuda@disopra.com',
            'password' => bcrypt('muda1q2w3e'),
            'id_skpd' => $skpd->id,
            'id_urusan' => $urusan_pemuda->id,
            'id_role' => 3,
        ])->assignRole('Verifikator');

        $reviewer_pemuda = User::create([
            'name' => 'Reviewer Pemuda',
            'email' => 'reviewer.pemuda@disopra.com',
            'password' => bcrypt('muda1q2w3e'),
            'id_skpd' => $skpd->id,
            'id_urusan' => $urusan_pemuda->id,
            'id_role' => 4,
        ])->assignRole('Reviewer');
    }
}
