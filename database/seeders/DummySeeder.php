<?php

namespace Database\Seeders;

use App\Models\Lembaga;
use App\Models\PendukungPermohonan;
use App\Models\Permohonan;
use App\Models\RabPermohonan;
use App\Models\Skpd;
use App\Models\User;
use App\Services\ActivityLogService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::beginTransaction();
        try {
            $user_koni = User::create([
                'name' => 'Admin Komite Olahraga Nasional Indonesia',
                'email' => 'koni@example.com',
                'password' => bcrypt('@zaq123qwerty'),
                'id_role' => 5,
            ])->assignRole('Admin Lembaga');

            $lembaga = Lembaga::create([
                'name' => 'Komite Olahraga Nasional Indonesia',
                'acronym' => 'KONI',
                'email' => 'koni.bkt@gmail.com',
                'phone' => '00000000',
                'id_skpd' => 1,
                'id_urusan' => 2,
                'id_kelurahan' => 18,
                'alamat' => 'jalan 1 gang 2',
                'photo' => 'data_lembaga/lembaga_2_photo.jpg',
                'npwp' => '11111111',
                'no_akta_kumham' => '121',
                'date_akta_kumham' => '2025/2/6',
                'file_akta_kumham' => 'data_lembaga/lembaga_2_akta_kumham.pdf',
                'no_domisili' => '131',
                'date_domisili' => '2025/2/6',
                'file_domisili' => 'data_lembaga/lembaga_2_domisili.pdf',
                'no_operasional' => '141',
                'date_operasional' => '2025/2/6',
                'file_operasional' => 'data_lembaga/lembaga_2_operasional.pdf',
                'no_pernyataan' => '151',
                'date_pernyataan' => '2025/2/6',
                'file_pernyataan' => 'data_lembaga/lembaga_2_pernyataan.pdf',
            ]);
            
            $pengurus = $lembaga->pengurus()->create([
                'name' => 'uum',
                'email' => 'uum.koni@example.com',
                'nik' => '111111111',
                'no_hp' => '00000000',
                'alamat' => 'jalan 2 gang 3',
                'scan_ktp' => 'pengurus/pimpinan_KONI2_scan_ktp.jpg',
            ]);

            $user_koni->update([
                'id_skpd' => 1,
                'id_urusan' => 1,
                'id_lembaga' => $lembaga->id,
            ]);

            $permohonan = Permohonan::create([
                'id_lembaga' => $lembaga->id,
                'tahun_apbd' => 2026,
                'no_mohon' => '161/KONI/II/2026',
                'tanggal_mohon' => '2025/2/6',
                'perihal_mohon' => 'permintaan dana kegiatan olahraga',
                'file_mohon' => 'permojonan/surat_permohonan_21820254.pdf',
                'no_proposal' => '161/KONI/II/2026',
                'tanggal_proposal' => '2025/2/6',
                'title' => 'Permintaan Dana Kegiatan Olahraga Tahun 2026',
                'urusan' => 2,
                'id_skpd' => 1,
                'awal_laksana' => '2026/1/2',
                'akhir_laksana' => '2026/12/31',
                'file_proposal' => 'permohonan/proposal_permohonan_21820254.pdf',
                'latar_belakang' => 'latar belakangan kegiatan olahraga',
                'maksud_tujuan' => 'maksud dan tujuan kegiatan olahraga',
                'keterangan' => 'Keterangan kegiatan olahraga',
                'nominal_rab' => 500000000,
                'id_status' => 4,
                'nominal_rekomendasi' => 0,
                'tanggal_rekomendasi' => null,
                'catatan_rekomendasi' => null,
                'file_pemberitahuan' => null,
            ]);

            $create_pendukung_permohonan = PendukungPermohonan::create([
                'id_permohonan' => $permohonan->id,
                'file_pernyataan_tanggung_jawab' => 'permohonan/tanggung_jawab_21820254.pdf',
                'struktur_pengurus' => 'permohonan/pengurus_21820254.pdf',
                'file_rab' => 'permohonan/rab_21820254.pdf',
                'saldo_akhir_rek' => 'permohonan/saldo_akhir_21820254.pdf',
                'no_tidak_tumpang_tindih' => '171',
                'tanggal_tidak_tumpang_tindih' => '2025/2/6',
                'file_tidak_tumpang_tindih' => 'permohonan/tidak_tumpang_tindih_21820254.pdf',
            ]);

            $data_kegiatan_rab = [
                [
                    'id_permohonan' => $permohonan->id,
                    'nama_kegiatan' => 'Tambah Alat Olahraga',
                    'subtotal' => 450000000,
                ],
                [
                    'id_permohonan' => $permohonan->id,
                    'nama_kegiatan' => 'Festival Olahraga',
                    'subtotal' => 50000000,
                ]
            ];

            foreach($data_kegiatan_rab as $k1 => $item){
                RabPermohonan::create($item);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }


    }
}
