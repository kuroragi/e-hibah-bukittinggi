<?php

use App\Models\PertanyaanKelengkapan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pertanyaan_kelengkapans', function (Blueprint $table) {
            //
        });

        $pertanyaan = [
            [
                'question' => 'Kelengkapan proposal usulan hibah/bansos',
                'id_parent' => null,
                'order' => '1', 
                'child' => [
                    ['question' => 'Identitas dan alamat pengusul','order' => '1',],
                    ['question' => 'latar belakang','order' => '2',],
                    ['question' => 'maksud dan tujuan','order' => '3',],
                    ['question' => 'rincian rencana kegiatan )jadwal pelaksanaan kegiatan','order' => '4',],
                    ['question' => 'rincian rencana penggunaan hibah/bansos (rincian anggaran biaya)','order' => '5',],
                    ['question' => 'jenis barang/rincian pekerjaan jasa','order' => '6',],
                    ['question' => 'volume, harga/rincian biaya barang/jasa','order' => '7',],
                    ['question' => 'lokasi pemberian barang /jasa','order' => '8',],
                ]
            ],[
                'question' => 'Dokumen Administrasi ',
                'id_parent' => null,
                'order' => '2',
                'child' => [
                    ['question' => 'Fotokopi kartu tanda penduduk (KTP) (Kartu/pimpinan badan, lembaga atau organisasi kemasyarakatan)','order' => '1',],
                    ['question' => 'Fotokopi Akta Notaris pendirian badan hukum yang telah mendapat pengesahan dari kementerian yang membidangi hukum atau keputusan Gubernur tentang pembentukan organisasi/lembaga atau dokumen lain yang di persamakan','order' => '2',],
                    ['question' => 'fotokopi nomor poko wajib pajak (NPWP)','order' => '3',],
                    ['question' => 'fotokopi surat ketengan domisi organisasi kemasyarakatan dari kelurahan setempat atau sebutan lainnya','order' => '4',],
                    ['question' => 'fotokopi izin operasional/tanda daftar lembaga dari instansi yang berwenang','order' => '5',],
                    ['question' => 'fotokopi sertifikat tanah/bukti kepemilikan tanah atau bukti perjanjian sewa bangunan/gedung dengan jangka waktu sewa minimal 3 (tiga) tahun atau dokumen lain yang dipersamakan','order' => '6',],
                    ['question' => 'surat pernyataan tanggung jawab bermaterai','order' => '7',],
                    ['question' => 'surat pernyataan tidak tumpang tinih pendanaannya dari sumber dana lainnya yang ditandatangani oleh penerima hibah','order' => '8',],
                    ['question' => 'salinan rekening bank yang masih aktif atas nama badan, lembaga atau organisasi kemasyarakatan','order' => '9',],
                    ['question' => 'fotokopi SK kepengurusan atau dokumen yang di persamakan*)','order' => '10',],
                    ['question' => 'bantuan yang pernah diterima tahun sebelumnya apabila ada (tanda terima laporan pertanggung-jawaban)*)','order' => '11',],
                    ['question' => 'melampirkan 3 (tiga) pembanding harga atas disesuaikan dengan standar satuan harga yang berlaku','order' => '12',],
                ]
            ],[
                'question' => 'Kesesuaian usulan kegiatan',
                'id_parent' => null,
                'order' => '3',
                'child' => [
                    ['question' => 'kesesuaian usulan hibah dengan sasaran, program, kegiatan, dan web kegiatan SKPD/Unit SKPD pemerinta daerah','order' => '1',],
                    ['question' => 'kesesuaian bidang urusan pemohon hibah dengan bidang urusan SKPD/unit SKPD','order' => '2',],
                    ['question' => 'kesesuaian kewajaran jangka waktu pelaksanaan kegiatan hibah','order' => '3',],
                    ['question' => 'merupakan barang/jasa yang harganya terukur dan bersifat umum **)','order' => '4',],
                    ['question' => 'memberikan nilai manfaat bagi pemerintahan provinsi DKI jakarta dalam mendukung terselenggaranya fungsi pemerintahan, pembangunan dan kemasyarakatan yang terdaftar dalam rencana pembangunan jangka menegah daerah','order' => '5',],
                ]
            ],[
                'question' => 'Tidak terus menerus setiap tahun anggaran',
                'id_parent' => null,
                'order' => '4',
                'child' => [
                    ['question' => 'telah menerima hibah/bantuan tahun sebelumnya','order' => '1',],
                    ['question' => 'memenuhi kriteria pengecualian tidak terus menerus setiap tahun anggaran:<br>1. kepada pemerintahan pusat dalam rangka mendukung penyelenggaraan pemerintahan daerah<br>2. ditentukan oleh peraturan perundang-undangan','order' => '2',],
                ]
            ]
        ];

        foreach($pertanyaan as $item){
            $p = PertanyaanKelengkapan::create([
                'question' => $item['question'],
                'id_parent' => $item['id_parent'],
                'order' => $item['order'],
            ]);

            foreach($item['child'] as $i2){
                PertanyaanKelengkapan::create([
                'question' => $i2['question'],
                'id_parent' => $p->id,
                'order' => $i2['order'],
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pertanyaan_kelengkapans', function (Blueprint $table) {
            DB::table('pertanyaan_kelengkapans')->truncate();
        });
    }
};
